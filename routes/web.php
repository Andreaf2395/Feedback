<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/feedbackform', 'FeedbackController@fetch_form');




Route::post('/imageupload', 'ImageUploadController@uploadImage');
Route::delete('/removeimage', 'ImageUploadController@deleteImage');

Route::get('/faculty/{clg}', 'FeedbackController@getfaculty');

Route::post('/faculty_save','FeedbackController@storefaculty');
Route::post('savefeedback','FeedbackController@store');


//Route::get('trial','FeedbackController@fetch_new_form');

//Route::post('/newimageupload','ImageUploadController@newimageupload');