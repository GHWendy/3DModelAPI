<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Figure;
use App\User;
use App\Http\Requests\FigureRules;
use Illuminate\Http\Request;
use App\Http\Resources\FigureResource;
use App\Http\Resources\FigureCollection;
use App\Exceptions\ErrorHandler;

class FigureController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api', ['only' => ['store', 'update', 'destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Figure::count();
        if( $rows>0 ) {
            $type = 'public'; //por default se mostrarán todos los modelos públicos
            $limit = request()->has('limit') ? (int) request('limit') : 10;
            $difficulty = request('difficulty');
            $user = auth('api')->user();
            $user_id = null;
            if( $user ){
                $user_id = $user->id;
            }
            $figures = Figure::when($difficulty, function ($query, $difficulty) {
                    return $query->where('difficulty', $difficulty);
                })
                ->where(function ($query) use($type, $user_id) {
                    $query->where('type', $type)
                    ->when($user_id, function($query, $user_id) {
                        return $query->orWhere('user_id', $user_id);
                    });
                });

            if($user){
                $figuresInGroups =Figure::join('figures_groups', 'figures.id', '=', 'figures_groups.figure_id')
                    ->join('groups', 'figures_groups.group_id', '=', 'groups.id')
                    ->join('users_groups', 'groups.id', '=', 'users_groups.group_id')
                    ->join('users', 'users_groups.group_id', '=', 'users.id')->select('figures.*')->where('users_groups.user_id', $user_id)->distinct();
                $figures = $figures->union($figuresInGroups)->orderBy('id')->paginate($limit);
            }else{
                $figures = $figures->orderBy('id')->paginate($limit);
            }
            return response()->json(new FigureCollection($figures), 200);    
        }
        return response()->json([],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FigureRules $request)
    {
        $prefix = 'data.attributes.';
        $figure_data['user_id'] = Auth::id();
        $figure_data['name'] = $request->input($prefix.'name');
        $figure_data['image_preview'] = $request->input($prefix.'image_preview');
        $figure_data['description'] = $request->input($prefix.'description');
        $figure_data['x'] = $request->input($prefix.'dimensions.x');
        $figure_data['y'] = $request->input($prefix.'dimensions.y');
        $figure_data['z'] = $request->input($prefix.'dimensions.z');
        $figure_data['difficulty'] = $request->input($prefix.'difficulty');
        $figure_data['glb_download'] = $request->input($prefix.'glb_download');
        $figure_data['type'] = $request->input($prefix.'type');
        $figure = Figure::create($figure_data);
        return (new FigureResource($figure))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Figure  $figure
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $figure = Figure::find($id);
        if( $figure ) {
            $user = auth('api')->user();
            if($user){
                Auth::login($user);
            } 
            $response = Gate::inspect('view', $figure);
            if(!$response->allowed()){
                $this->authorize('accessWhenIsInAGroup', $figure);
            }
            return new FigureResource($figure);

            //Before
            //$response = Gate::inspect('view', $figure);
            /*if($response->allowed()){
                return new FigureResource($figure);
            }else{
                (new ErrorHandler())->forbidden($response->message());
            }*/
        }
        (new ErrorHandler())->notFound('There is not a figure with the id: ' . $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Figure  $figure
     * @return \Illuminate\Http\Response
     */
    public function update(FigureRules $request, $id)
    {
        $figure = Figure::find($id);
        if( $figure ) {
            $this->authorize('update', $figure);
            $this->authorize('editType', $figure);
            
            $figure->name = $request->input('data.attributes.name') ? $request->input('data.attributes.name') : $figure->name;
            $figure->image_preview = $request->input('data.attributes.image_preview') ? $request->input('data.attributes.image_preview') : $figure->image_preview;
            $figure->description = $request->input('data.attributes.description') ? $request->input('data.attributes.description') : $figure->description;
            $figure->x = $request->input('data.attributes.dimensions.x') ? $request->input('data.attributes.dimensions.x') : $figure->x;
            $figure->y = $request->input('data.attributes.dimensions.y') ? $request->input('data.attributes.dimensions.y') : $figure->y;
            $figure->z = $request->input('data.attributes.dimensions.z') ? $request->input('data.attributes.dimensions.z') : $figure->z;
            $figure->difficulty = $request->input('data.attributes.difficulty') ? $request->input('data.attributes.difficulty') : $figure->difficulty;
            $figure->glb_download = $request->input('data.attributes.glb_download') ? $request->input('data.attributes.glb_download') : $figure->glb_download;
            $figure->type = $request->input('data.attributes.type') ? $request->input('data.attributes.type') : $figure->type;
            $figure->save();
            return new FigureResource($figure); 
        }
        (new ErrorHandler())->notFound('There is not a figure with the id: ' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Figure  $figure
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $figure = Figure::find($id);
        if($figure){
            $this->authorize('delete',$figure);
            //Eliminar comentarios y detach de figures_groups
            $figure->detachGroups($figure);
            $figure->deleteComments($figure);
            
            $figure->delete();
            return response()->json('',204);
        }
        (new ErrorHandler())->notFound('There is not a figure with the id: ' . $id);
    }
}
