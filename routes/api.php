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

// Route::get('/users', function (Request $request){
//     return '';
// });
//Get a group
Route::get('/groups/{id}', "GroupController@show");
//Get members
Route::get('/groups/{id}/members', "GroupController@showMembers");
//Create a group
Route::post('/groups' , "GroupController@store");
//Update group
Route::put('/groups/{id}' , "GroupController@edit");
//Add user to group
Route::put('/groups/{id}/members' , "GroupController@addMember");
//Add a figure to a group
Route::put('/groups/{id}/figures' , "GroupController@addFigure");
//Delete a group
Route::delete('/groups/{id}' , "GroupController@destroy");
//Delete a member of a group
Route::delete('/groups/{id}/members/{id}' , "GroupController@removeMember");
//Delete a figure of a group
Route::delete('/groups/{id}/figures/{id}' , "GroupController@removeFigure");






