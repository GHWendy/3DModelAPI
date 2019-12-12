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

//Route::get('users', 'UserController@index');

// Route::get('users/{id}', 'UserController@show');
// Route::post('users', 'UserController@store');
// Route::put('users/{id}', 'UserController@update');
// Route::delete('users/{id}', 'UserController@destroy');
// Route::get('users/{user_id}/figures', 'UserController@showFigures');
// Route::get('users/{user_id}/groups', 'UserController@showGroups');

Route::group(['prefix' => 'v1'], function () {
    $prefix = "Api\\v1\\";
    //Ejemplo de ruta para la versión 1
    Route::get('users', $prefix . 'UserController@index');
    Route::get('users/{id}', $prefix . 'UserController@show');
    Route::post('users', $prefix . 'UserController@store');
    Route::put('users/{id}', $prefix . 'UserController@update');
    Route::delete('users/{id}', $prefix . 'UserController@destroy');

    Route::get('figures/{figure_id}/comments', $prefix . 'CommentController@index');
    Route::post('figures/{figure_id}/comments', $prefix . 'CommentController@store');
    Route::delete('figures/{figure_id}/comments/{comment_id}', $prefix . 'CommentController@destroy');

});

Route::post('login', 'Auth\\LoginController@authenticate');
//Route::post('login', 'LoginController');
// Route::get('/users', function (Request $request){
//     return '';
// });


