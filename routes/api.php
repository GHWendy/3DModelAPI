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


