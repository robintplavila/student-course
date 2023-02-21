<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ResultController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::controller(TodoController::class)->group(function () {
    Route::get('todo', 'index');
    Route::post('todo', 'store');
    Route::get('todo/{id}', 'show');
    Route::put('todo/{id}', 'update');
    Route::delete('todo/{id}', 'destroy');
}); 

// Route::controller(UserController::class)->group(function () {
//     Route::get('user', 'index');
//     // Route::post('todo', 'store');
//     // Route::get('todo/{id}', 'show');
//     // Route::put('todo/{id}', 'update');
//     // Route::delete('todo/{id}', 'destroy');
// }); 

// Route::group([

//     // 'middleware' => 'api',
//      'namespace' => 'App\Http\Controllers\API\V1',
//      //'prefix' => 'auth'
 
//  ], function ($router) {
 
     Route::apiResources([
         'user_role' => UserRoleController::class,
         'user'=>UserController::class,
         'course'=> CourseController::class,
         'result'=> ResultController::class           
     ]);  
     Route::get('getCourse', [CourseController::class, 'getCourse']); 
     Route::get('getStudent', [UserController::class, 'getStudent']); 
     Route::get('getCourseCount', [CourseController::class, 'getCourseCount']); 
     Route::get('getStudentCount', [UserController::class, 'getStudentCount']); 
     Route::get('getResultCount', [ResultController::class, 'getResultCount']); 
 
//  });