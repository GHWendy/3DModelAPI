<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Figure;
use App\Http\Requests\FigureRules;
use Illuminate\Http\Request;
use App\Http\Resources\FigureResource;
use App\Http\Resources\FigureCollection;
use App\Exceptions\ErrorHandler;

class FigureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Falta: validar si el usuario está logueado mostrar aquellos públicos, y sus privados e incluso aquellos que tenga en otros grupos (esto último talvez no)
        //para los usuarios no logueados solo de tipo publico (all(where id ...))
        $rows = Figure::count();
        if( $rows>0 ) {
            $figures = Figure::all();
            return response()->json(new FigureCollection($figures), 200);
        }
        return response()->json([],200);
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
    public function store(FigureRules $request)
    {
        return "Se validaron todos los atributos solo falta ver como asociar un usuario con una figura......";
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
            return new FigureResource($figure);
        }
        (new ErrorHandler())->notFound('There is not a figure with the id: ' . $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Figure  $figure
     * @return \Illuminate\Http\Response
     */
    public function edit(Figure $figure)
    {
        //
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
            $figure->name = $request->input('data.attributes.name');
            $figure->image_preview = $request->input('data.attributes.image_preview');
            $figure->description = $request->input('data.attributes.description');
            $figure->x = $request->input('data.attributes.dimensions.x');
            $figure->y = $request->input('data.attributes.dimensions.y');
            $figure->z = $request->input('data.attributes.dimensions.z');
            $figure->difficulty = $request->input('data.attributes.difficulty');
            $figure->glb_download = $request->input('data.attributes.glb_download');
            $figure->type = $request->input('data.attributes.type');
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
            $figure->delete();
            return response()->json('',204);
        }
        (new ErrorHandler())->notFound('There is not a figure with the id: ' . $id);
    }
}
