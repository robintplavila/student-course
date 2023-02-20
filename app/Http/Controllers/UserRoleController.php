<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;

class UserRoleController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }   
    
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortKey = $request->get('sort_key');
        $sortOrder = $request->get('sort_order');
        $searchText = $request->get('query');
        if ($sortKey == "") {
            $sortKey = 'role_name';
        }
        if ($searchText) {
            $roles = UserRole::where('role_name', 'LIKE', '%'.$searchText.'%')
            ->orderBy($sortKey, $sortOrder)->paginate(50);
        } else {
            $roles = UserRole::orderBy($sortKey, $sortOrder)->paginate(50);
        }
        foreach ($roles as $key => $role) {
            $roles[$key]['role_id']=Crypt::encrypt($role->id);
        }
        return response()->json($roles);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            ['role_name' => 'string|max:191|unique:user_roles,role_name,NULL,id,deleted_at,NULL'], 
            ['role.unique' => 'The role has already been taken']
        );
       
        $role = UserRole::create([
            'role_key' => $request['role_name'],
            'role_name' => $request['role_name'],
            
        ]);
    
        return $this->sendResponse($role, 'User Role Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $roleId = Crypt::decrypt($id);
        $userRole = UserRole::findOrFail($roleId);
      
        return response()->json($userRole);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $roleId = Crypt::decrypt($id);
        $userRole = UserRole::findOrFail($roleId);
        if ($request['role_name'] !=  $userRole->role_name) {
            $result = UserRole::select('user_roles.role_name')        
            ->where('user_roles.role_name', $request['role_name'])
            ->get();
            if (!$result->isEmpty()) {
                throw ValidationException::withMessages([
                    'role' => 'Role exists ',
                ]);
            }
        }        
        $userRole->update([
            'role_key' => $request['role_name'],
            'role_name' => $request['role_name'],
        ]);
        return $this->sendResponse($userRole, 'User Role Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $roleId = Crypt::decrypt($id);
        $userRole = UserRole::findOrFail($roleId);
        $userRole->delete();
        return $this->sendResponse($userRole, 'User Role has been Deleted');
    }
}
