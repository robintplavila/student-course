<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class CourseController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $sortKey = $request->get('sort_key');
        $sortOrder = $request->get('sort_order');
        $searchText = $request->get('query');
        if ($sortKey == "") {
            $sortKey = 'course_name';
        }
        if ($searchText) {
            $courses = Course::where('course_name', 'LIKE', '%'.$searchText.'%')
            ->orderBy($sortKey, $sortOrder)->paginate(50);
        } else {
            $courses = Course::orderBy($sortKey, $sortOrder)->paginate(50);
        }
        foreach ($courses as $key => $course) {
            $courses[$key]['course_id']=Crypt::encrypt($course->id);
        }
        return response()->json($courses);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {  
        $course = Course::create([            
            'course_name' => $request['course_name']
            
        ]);
    
        return $this->sendResponse($course, 'Course Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $courseId = Crypt::decrypt($id);
        $course = Course::findOrFail($courseId);
      
        return response()->json($course);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $courseId = Crypt::decrypt($id);
        $course = Course::findOrFail($courseId);
        if ($request['course_name'] !=  $course->course_name) {
            $result = Course::select('course_name')        
            ->where('course_name', $request['course_name'])
            ->get();
            if (!$result->isEmpty()) {
                throw ValidationException::withMessages([
                    'course' => 'Course exists ',
                ]);
            }
        }        
        $course->update([            
            'course_name' => $request['course_name']
        ]);
        return $this->sendResponse($course, 'Course Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $courseId = Crypt::decrypt($id);
        $course = Course::findOrFail($courseId);
        $course->delete();
        return $this->sendResponse($course, 'Course has been Deleted');
    }
}
