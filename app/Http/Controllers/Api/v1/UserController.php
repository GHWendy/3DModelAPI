<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\User;
use App\Figure;
use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests\UserRules;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\ErrorHandler;
use App\Http\Resources\FigureCollection;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['only' => ['update', 'destroy', 'showGroups']]);
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $validated = $request->validated();

        $user = User::create($request->get('data')['attributes']);
        $user->password = Hash::make($request->input('data.attributes.password'));
        $user->api_token = Str::random(80);
        $user->save();
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
            return (new UserResource($user))->response()->setStatusCode(200);
        }
        (new ErrorHandler())->notFound('There is not a user with the id: ' . $id);
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
            $user->deleteFigures($user);
            $user->detachGroups($user);
            $user->deleteComments($user);

            $user->delete();
            return response()->json(200);
        }
        (new ErrorHandler())->notFound('There is not a user with the id: ' . $id);
        return 'estas logueado por lo tanto existes, entonces siempre debería regresar o
        que fue exitoso o que no eres el usuario con el id dado';
    }

    public function showFigures($user_id)
    {
        $limit = request()->has('limit') ? (int) request('limit') : 10;
        $userH = User::find($user_id);
        if ($userH) {
            $userA = auth('api')->user();

            $figures = Figure::where('user_id', $user_id)
                        ->when($userA, function ($query, $userA) use($user_id) {
                            return $query->when($userA->id != $user_id, function ($query) { //The user is logged in and tries to get another user figures
                                return $query->where('type', 'public');
                            });
                        }, function ($query) {
                            return $query->where('type', 'public'); //A user tries to get models from another figure
                        });
            return response()->json(new FigureCollection($figures->orderBy('id')->paginate($limit)), 200);
        }
        (new ErrorHandler())->notFound('There is not a user with the id: ' . $user_id);
        
        
        return response()->setStatusCode(200);
    }

    public function showGroups()
    {
        return response()->setStatusCode(200);
    }
}
