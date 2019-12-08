<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //listar
        //return response()->json(200);
        return "Estás en la version 1 de esta API, FELICIDADES :D";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return User::forceCreate([
            'name' => 'El Beto',
            'profile_picture' => 'www.google.com',
            'age' => 21,
            'gender' => 'male',
            'email' => 'hpech1@gmail.com',
            'email_verified_at' => '2019-12-07 22:43:01',
            'password' => Hash::make('12345678'),
            'api_token' => Str::random(80),
            'remember_token' => '2019-12-07 22:43:01'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Crear usuario
        return response()->json(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //mostrar un usuario
        return response()->json(200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Actualizar
        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Eliminar
        return response()->json(200);
    }

    public function showFigures()
    {
        return response()->json(200);
    }

    public function showGroups()
    {
        return response()->json(200);
    }
}
