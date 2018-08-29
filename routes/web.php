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




Route::post('/imageupload', 'ImageUploadController@uploadlabImage');
Route::delete('/removeimage', 'ImageUploadController@deletelabImage');

Route::get('/faculty/{clg}', 'FeedbackController@getfaculty');

Route::post('/faculty_save','FeedbackController@storefaculty');
Route::post('savefeedback','FeedbackController@store');

Route::post('/saveprojectfeedback','FeedbackController@store_project');

Route::post('/projectImageUpload','ImageUploadController@uploadprojectImage');

Route::delete('/removeProjectImage','ImageUploadController@deleteprojectImage');

Route::view('/submit_complete','feedback.success');




Route::get('/proj_form', function () {
    return view('feedback.project_form');
});

Route::get('/feedback', function () {
    return view('test');
});
Route::post('/storedata','SubmitController@store');
//Route::get('trial','FeedbackController@fetch_new_form');

//Route::post('/newimageupload','ImageUploadController@newimageupload');