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
    //Create a group
	Route::post('groups' , $prefix .'GroupController@store');
	//Get a group
	Route::get('groups/{id}', $prefix ."GroupController@show");
    //Get members
	Route::get('groups/{id}/members', $prefix . "GroupController@showMembers");
	//Update group
	Route::put('groups/{id}' , $prefix .  "GroupController@update");	
	//Add user to group
	Route::put('groups/{id}/members' , $prefix .  "GroupController@updateMembers");	
	//Add a figure to a group
	Route::put('groups/{id}/figures' , $prefix .  "GroupController@updateFigures");
	//Delete a group
	Route::delete('groups/{id}' , $prefix .  "GroupController@destroy");
	
	//Delete a member of a group
	Route::delete('groups/{group_id}/members/{id}' , $prefix .  "GroupController@removeMember");
	
	//Delete a figure of a group
	Route::delete('groups/{group_id}/figures/{id}' , $prefix .  "GroupController@removeFigure");

    //Endpoints for the User model
    Route::get('users', $prefix . 'UserController@index');
    Route::get('users/{id}', $prefix . 'UserController@show');
    Route::post('users', $prefix . 'UserController@store');
    Route::put('users/{id}', $prefix . 'UserController@update');
    Route::delete('users/{id}', $prefix . 'UserController@destroy');
    Route::get('users/{user_id}/figures', $prefix . 'UserController@showFigures');
    Route::get('users/{user_id}/groups', $prefix . 'UserController@showGroups');


    //Endpoints for Figure model
    Route::get('figures', $prefix . 'FigureController@index');
    Route::get('figures/{id}', $prefix . 'FigureController@show');
    Route::post('figures', $prefix . 'FigureController@store');
    Route::put('figures/{id}', $prefix . 'FigureController@update');
    Route::delete('figures/{id}', $prefix . 'FigureController@destroy');

    //Endpoints for Comment model
    Route::get('figures/{figure_id}/comments', $prefix . 'CommentController@showAllFigureComments');
    Route::post('figures/{figure_id}/comments', $prefix . 'CommentController@store');
    Route::delete('figures/{figure_id}/comments/{id}', $prefix . 'CommentController@destroy');

    
    //También se pueden proteger los guards así 
    //Route::middleware('auth:api')->post('figures', $prefix . 'FigureController@store');

    //Ejemplo de ruta para la versión 1
    Route::get('users', $prefix . 'UserController@create');
});

Route::post('login', 'Auth\\LoginController@authenticate');
//Route::post('login', 'LoginController');
// Route::get('/users', function (Request $request){
//     return '';
// });

