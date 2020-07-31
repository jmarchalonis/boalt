<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', 'Api\AuthController@login');
Route::post('/register', 'Api\AuthController@register');
Route::get('/users/getUserDetails', 'Api\UsersController@getUserDetails')->middleware('auth:api');

Route::get('/notifications/get', 'Api\NotificationsController@getNotifications')->middleware('auth:api');
Route::post('/notifications/create', 'Api\NotificationsController@createNotification')->middleware('auth:api');
Route::patch('/notifications/markRead', 'Api\NotificationsController@markNotificationRead')->middleware('auth:api');
Route::delete('/notifications/delete', 'Api\NotificationsController@deleteNotification')->middleware('auth:api');

Route::get('/amazon/bucket/objects/get', 'Api\AmazonController@listBucketObjects')->middleware('auth:api');
Route::post('/amazon/bucket/objects/create', 'Api\AmazonController@createObject')->middleware('auth:api');
Route::delete('/amazon/bucket/objects/delete', 'Api\AmazonController@deleteObject')->middleware('auth:api');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
