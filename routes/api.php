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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    $prefix = 'Api\\v1\\';
    //Endpoints for Groups
	//Get a group
	Route::get('groups/{id}', $prefix ."GroupController@show");
	//Get members
	Route::get('groups/{id}/members', $prefix . "GroupController@showMembers");
	//Create a group
	Route::post('groups' , $prefix . "GroupController@store");
	//Update group
	Route::put('groups/{id}' , $prefix .  "GroupController@edit");
	//Add user to group
	Route::put('groups/{id}/members' , $prefix .  "GroupController@addMember");
	//Add a figure to a group
	Route::put('groups/{id}/figures' , $prefix .  "GroupController@addFigure");
	//Delete a group
	Route::delete('groups/{id}' , $prefix .  "GroupController@destroy");
	//Delete a member of a group
	Route::delete('groups/{id}/members/{id}' , $prefix .  "GroupController@removeMember");
	//Delete a figure of a group
	Route::delete('groups/{id}/figures/{id}' , $prefix .  "GroupController@removeFigure");

});









