<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/resource/uploader', 'ResourceController@uploader');
Route::put('/resource/{id}/status', 'ResourceController@changeStatus');
Route::get('/courses', 'CourseController@fetchList');
Route::get('/course/{id}', 'CourseController@fetchOne');
Route::put('/course', 'CourseController@storage');