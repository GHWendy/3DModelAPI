<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Figure;
use App\Http\Requests\FigureRules;
use Illuminate\Http\Request;
use App\Http\Resources\FigureResource;
use App\Http\Resources\FigureCollection;

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
        return response()->json([],404);
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
    public function update(Request $request, Figure $figure)
    {
        $figure = Figure::find($id);
        if( $figure ) {
            $figure->name = $request->input('data.attribute.name');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Figure  $figure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Figure $figure)
    {
        //
    }
}
