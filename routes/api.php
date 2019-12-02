<?php

use Illuminate\Http\Request;
use App\Laravue\Faker;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//============api for web=======//
Route::group(['prefix'=>'admin', 'namespace' => 'ApiWeb'], function () {
    Route::post('auth/login', 'AuthController@login');
});
Route::get('master-data', 'ApiWeb\\UserController@masterData');
Route::group(['namespace' => 'ApiWeb', 'middleware' => 'auth:api'], function () {
    Route::get('auth/user', 'AuthController@user');
    Route::post('auth/logout', 'AuthController@logout');

    Route::group(['prefix' => 'words'], function() {
        Route::get('list', 'WordController@getList');

        Route::get('all', 'WordController@getAll');

        Route::post('store', 'WordController@store');

        Route::post('update', 'WordController@update');

        Route::post('destroy', 'WordController@destroy');

        Route::post('import', 'WordController@import');
    });

    Route::group(['prefix' => 'users'], function() {
        Route::get('list', 'UserController@getList');

        Route::post('update-field', 'UserController@updateField');
    });

    Route::post('upload-img', 'UploadController@upload');
});

//==========api for app=============//
Route::group(['namespace' => 'Api', 'middleware'=>['apibase']], function() {

	Route::group(['prefix'=>'users'], function (){
        Route::post('/login', 'UsersController@login');
        Route::post('/register', 'UsersController@register');
        Route::post('/forgotPassword', 'UsersController@forgotPassword');
	});
});

Route::group(['namespace' => 'Api', 'middleware'=>['apibase','apitoken', 'expire']], function() {

    Route::group(['prefix'=>'users'], function (){
        Route::get('/getUserInformation', 'UsersController@getUserInformation');
        Route::post('/updateUserInformation', 'UsersController@updateUserInformation');
        Route::get('/getAllServices', 'UsersController@getAllServices');
        Route::post('/updateUserAccountAfterPayment', 'UsersController@updateUserAccountAfterPayment');
    });
});
