<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ResultController extends BaseController
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
            $sortKey = 'score';
        }
        if ($searchText) {
            $results = Result::select('results.*','users.id as user', 'users.name as student', 'courses.course_name as course')
            ->leftJoin('courses', 'courses.id', '=', 'results.course_id')
            ->leftJoin('users', 'users.id', '=', 'results.user_id')
            ->where('course_name', 'LIKE', '%'.$searchText.'%')
            ->orderBy($sortKey, $sortOrder)->paginate(50);
        } else {
            $results = Result::select('results.*','users.id as user', 'users.name as student', 'courses.course_name as course')
            ->leftJoin('courses', 'courses.id', '=', 'results.course_id')
            ->leftJoin('users', 'users.id', '=', 'results.user_id')
            ->orderBy($sortKey, $sortOrder)->paginate(50);
        }
        foreach ($results as $key => $result) {
            $results[$key]['result_id']=Crypt::encrypt($result->id);
        }
        return response()->json($results);
    }   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        

        $results = Result::create([
            'course_id' => $request->course_id,
            'user_id' => $request->user_id,
            'score' => $request->score,
        ]);

        return $this->sendResponse($results, 'Result Created Successfully');        
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $resultId = Crypt::decrypt($id);
        $results = Result::find($resultId);
        return response()->json($results);
    }
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {        

        $resultId = Crypt::decrypt($id);
        $result = Result::findOrFail($resultId);
        $result->course_id = $request->course_id;
        $result->user_id = $request->user_id;
        $result->score = $request->score;
        $result->save();

        return $this->sendResponse($result, 'Result has been updated');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $resultId = Crypt::decrypt($id);
        $results = Result::findOrFail($resultId);        
        $results->delete();
        return $this->sendResponse($results, 'Results has been deleted');
    }

    public function getResultCount()
    {
        $results = Result::count();
        return response()->json($results);
    }
}
