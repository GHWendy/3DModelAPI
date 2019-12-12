<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests\UserRules;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\ErrorHandler;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['only' => ['update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        if ($users) {
            return (new UserCollection($users))->response()->setStatusCode(200);
        }
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

        $user = User::create($request->get('data')['attributes']);
        // print($request->input('data.attributes.password'));
        $user->password = Hash::make($request->input('data.attributes.password'));
        $user->api_token = Str::random(80);
        $user->save();
        //return $user->password;
        // return User::forceCreate([
        //     'name' => 'Alex',
        //     'email' => Str::random(6) . '@' .Str::random(4) . '.com',
        //     'email_verified_at' => '2019-12-07 22:43:01',
        //     'password' => Hash::make('12345678'),
        //     'api_token' => Str::random(80),
        //     'remember_token' => '2019-12-07 22:43:01'
        // ]);
        return (new UserResource($user))->response()->setStatusCode(201);
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
        if ($user) {
            print('existe');
            return (new UserResource($user))->response()->setStatusCode(200);
        }
        (new ErrorHandler())->notFound('There is not a user with the id: ' . $id);
        //return response()->setStatusCode(404);
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
        if ($user) {
            $this->authorize('update', $user);
            $user->name = $request->input('data.attributes.name');
            $user->email = $request->input('data.attributes.email');
            $user->password = Hash::make($request->input('data.attributes.password'));
            $user->save();
            return (new UserResource($user))->response()->setStatusCode(200);
        }
        (new ErrorHandler())->notFound('There is not a user with the id: ' . $id);
        // return response()->setStatusCode(404);
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
            $this->authorize('delete', $user);
            $user->delete();
            return response()->json(200);
        }
        (new ErrorHandler())->notFound('There is not a user with the id: ' . $id);
    }

    public function showFigures()
    {
        return response()->setStatusCode(200);
    }

    public function showGroups()
    {
        return response()->setStatusCode(200);
    }

}
