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


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/countries','HomeController@GetCountries');
Route::get('/cities/{country_id}','HomeController@GetCities');

Route::post('/login', 'Api\UserController@login');
Route::post('/register', 'Api\UserController@register');


Route::group(['middleware' => 'auth:api'], function()
{
    Route::prefix('users')->group(function (){
        Route::get('/user', 'Api\UserController@user');
        Route::get('/show/{id}', 'Api\UserController@show');
        Route::post('/all', 'Api\UserController@index');
        Route::post('/update/{id}', 'Api\UserController@update');
        Route::post('/changepassword/{id}', 'Api\UserController@changepassword');
        Route::post('/logout', 'Api\UserController@logout');
        Route::get('/qrcode', 'Api\BaseController@generateQrcode');
        Route::post('/qrcode', 'Api\UserController@saveQrcode');
    });

    Route::prefix('clinics')->group(function (){
        Route::get('/all', 'Api\ClinicController@index');
        Route::get('/show/{id}', 'Api\ClinicController@show');
        Route::post('/create', 'Api\ClinicController@store');
        Route::post('/update', 'Api\ClinicController@updateClinic');
        Route::post('/destroy/{id}', 'Api\ClinicController@destroy');
    });

    Route::prefix('visits')->group(function (){
        Route::get('/all', 'Api\VisitController@index');
        Route::get('/show/{id}', 'Api\VisitController@show');
        Route::post('/create', 'Api\VisitController@store');
        Route::post('/verify/{id}', 'Api\VisitController@verify');
        Route::post('/update', 'Api\VisitController@updateClinic');
        Route::post('/destroy/{id}', 'Api\VisitController@destroy');
    });

    Route::prefix('meetings')->group(function (){
        Route::get('/all', 'Api\MeetingController@index');
        Route::get('/show/{id}', 'Api\MeetingController@show');
        Route::post('/create', 'Api\MeetingController@store');
        Route::post('/update', 'Api\MeetingController@updateClinic');
        Route::post('/destroy/{id}', 'Api\MeetingController@destroy');
    });

    Route::prefix('journals')->group(function (){
        Route::post('/all', 'Api\JournalController@index');
        Route::get('/show/{id}', 'Api\JournalController@show');
        Route::post('/create', 'Api\JournalController@store');
        Route::post('/update', 'Api\JournalController@updateClinic');
        Route::post('/destroy/{id}', 'Api\JournalController@destroy');
    });

    Route::get('/doctors', 'UserController@index');
    Route::post('/profile', 'UserController@profile');

});
