<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\V1\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




// Open route
Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class,'login']);


// Protected route
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('profile', [ApiController::class,'profile']);
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::prefix('v1')->group(function () {
    Route::group([
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::get('task',[TaskController::class, 'getTasks']);
        Route::post('add-task',[TaskController::class, 'addTask']);
        Route::get('task/{id}',[TaskController::class, 'getTaskId']);
        Route::put('update-task/{id}',[TaskController::class, 'updateTask']);
        Route::delete('delete-task/{id}',[TaskController::class, 'deleteTask']);
    });
});
