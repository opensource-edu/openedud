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
Route::get('/resource', 'ResourceController@fetchResourceList');
Route::get('/courses', 'CourseController@fetchList');

Route::put('/course/{id}', 'CourseController@storage');
Route::get('/course/{id}', 'CourseController@fetchOne');
Route::put('/course', 'CourseController@storage');
Route::post('/course/{course_id}/table-of-content', 'CourseController@storageTableOfContent');
Route::put('/course/{course_id}/table-of-content', 'CourseController@storageTableOfContent');
Route::delete('/course/{course_id}/table-of-content/{toc_id}', 'CourseController@deleteTableOfContent');

Route::post('/table-of-content', 'TableOfContentController@storage');