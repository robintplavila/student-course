<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // public function index()
    // {
    //     $todos = User::all();
    //     return response()->json([
    //         'status' => 'success',
    //         'todos' => $todos,
    //     ]);
    // }

    public function index(Request $request)
    {
        $sortKey = $request->get('sort_key');
        $sortOrder = $request->get('sort_order');
        $searchText = $request->get('query');
        if ($sortKey == "") {
            $sortKey = 'first_name';
        }
        $roleKey = $request['role_key'];
        $users = new User();
        $users = $users->select('users.*', 'user_roles.id as role_id', 'user_roles.role_key', 'user_roles.role_name');
        $users = $users->leftJoin('user_roles', 'users.role_id', '=', 'user_roles.id');
        $users = $users->where('user_roles.role_key', '=', $roleKey);        
        if ($searchText) {
            $users = $users->where('first_name', 'LIKE', '%' . $searchText . '%')
                ->orWhere('family_name', 'LIKE', '%' . $searchText . '%')
                ->orWhere('email', 'LIKE', '%' . $searchText . '%')
                ->orderBy($sortKey, $sortOrder)->paginate(50);
        } else {
            $users = $users->orderBy($sortKey, $sortOrder)->paginate(50); //->toSql();
        }
        foreach ($users as $key => $user) {
            $users[$key]['user_id'] = Crypt::encrypt($user->id);   
            $users[$key]['user_id'] = Crypt::encrypt($user->id);        
            $users[$key]['date_of_birth'] = date("d-m-Y", strtotime($user->date_of_birth));
        }
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:191|unique:users,email,NULL,id,deleted_at,NULL',
            ], [
                'email.required' => 'Email is required',
                'email.unique' => 'Email is already taken',
            ]
        );       
        $usersdb = User::where('email', $request['email'])->onlyTrashed()->get();
        if (!empty($usersdb) && isset($usersdb[0]['id'])) {
            $usersId = $usersdb[0]['id'];
            User::withTrashed()->find($usersId)->restore();
            $user = User::find($usersId)->update([
                'name' => $request['first_name'] ." ". $request['family_name'],
                'first_name' => $request['first_name'],
                'family_name' => $request['family_name'],
                'date_of_birth' => date("Y-m-d", strtotime($request['date_of_birth'])),
                'email' => $request['email'],
                'role_id' => UserRole::where('role_key', '=', $request['role_key'])->first()->id,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);
        } else {
            $user = User::create([
                'name' => $request['first_name'] ." ". $request['family_name'],
                'first_name' => $request['first_name'],
                'family_name' => $request['family_name'],
                'date_of_birth' => date("Y-m-d", strtotime($request['date_of_birth'])),
                'email' => $request['email'],
                'role_id' => UserRole::where('role_key', '=', $request['role_key'])->first()->id,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);
        }            
        

        return $this->sendResponse($user, 'User Created Successfully');
    }

    public function show($id)
    {
        $userId = Crypt::decrypt($id);
        $user = User::findOrFail($userId);

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {

        $userId = Crypt::decrypt($id);
        $user = User::findOrFail($userId);
        // if (!empty($request->password)) {
        //     $request->merge(['password' => Hash::make($request['password'])]);
        // }
        $user->update([
            'name' => $request['first_name'] ." ". $request['family_name'],
            'first_name' => $request['first_name'],
            'family_name' => $request['family_name'],
            'date_of_birth' => date("Y-m-d", strtotime($request['date_of_birth'])),
            'email' => $request['email']
           // 'role_id' => UserRole::where('role_key', '=', $request['role_key'])->first()->id
        ]);
        // if (!empty($request->password)) {
        //     $user->update(['password' => $request['password']]);
        // }
        return $this->sendResponse($user, 'User Information has been updated');
    }

    public function destroy($id)
    {
        $userId = Crypt::decrypt($id);
        $user = User::findOrFail($userId);
        $user->delete();
        return $this->sendResponse($user, 'User has been Deleted');
    }
}
