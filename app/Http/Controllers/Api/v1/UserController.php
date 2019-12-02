<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\User;

use Illuminate\Http\Request;

use App\Http\Requests\UserRules;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        if($users) {
            return (new UserCollection($users))->response()->setStatusCode(200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRules $request)
    {
        //Crear usuario
        //$validated = $request->validated();
        //return response()->json(200);
        $validated = $request->validated();

        $user = User::create($request-> get('data')['attributes']);
        $user->password = Hash::make($request->input('data.attributes.password'));
        $user->save();
        //return $user->password;
        return (new UserResource($user)) -> response()->setStatusCode(201);
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
        $user = User::find($id);
        if($user) {
            return (new UserResource($user))->response()->setStatusCode(200);
        }

        return response()->setStatusCode(404);
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
    public function update(UserRules $request, $id)
    {
        $validated = $request->validated();
        //Actualizar
        $user = User::find($id);
        if($user) {
            $user->name = $request->input('data.attributes.name');
            $user->email = $request->input('data.attributes.email');
            $user->password = Hash::make($request->input('data.attributes.password'));
            $user->save();
            return (new UserResource($user))->response()->setStatusCode(200);
        }
        return response()->setStatusCode(404);
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
        $user = User::find($id);
        if ($user) {
            $user -> delete();
        return response()->json(200);
    }
        return response()->json(404);
    }

    public function showFigures()
    {
        return response()->setStatusCode(200);
    }

    public function showGroups()
    {
        return response()->setStatusCode(200);
    }

    private function hasheo() {
        $password = 'Hola';
        $Hasheado = Hash::make($password);
           $devuelto = Hash::check('Hola', $Hasheado);
           if($devuelto) {
            return  'Accedido';
           }
           return 'no';
    }
}
