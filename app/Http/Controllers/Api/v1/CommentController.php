<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Comment;
use App\Figure;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;
use App\Exceptions\ErrorHandler;

class CommentController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api', ['only' => ['store', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($figure_id)
    {
        $comments = Comment::paginate(10);
        return response()->json(new CommentCollection($comments),200);
    }

    public function showAllFigureComments($figure_id){
        $this->authorize('view',Figure::find($figure_id));

        $limit = request()->has('limit') ? (int) request('limit') : 10;

        $comments = Comment::where('figure_id', $figure_id)->paginate($limit);

        return response()->json(new CommentCollection($comments),200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request, $figure_id)
    {
        $response = Gate::inspect('view', Figure::find($figure_id));
        if(!$response->allowed()){
            $this->authorize('accessWhenIsInAGroup', Figure::find($figure_id));
        }
        
        $prefix = 'data.attributes.';
        $comment_data['user_id'] = Auth::id();
        $comment_data['figure_id'] = $figure_id;
        $comment_data['title'] = $request->input($prefix.'title');
        $comment_data['description'] = $request->input($prefix.'description');
        $comment = Comment::create($comment_data);
        return (new CommentResource($comment))->response()->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($figure_id, $id)
    {
        $comment = Comment::find($id);
        if($comment) {
            $this->authorize('delete', $comment);

            $comment->delete();
            return response()->json('',204);
        }
        (new ErrorHandler())->notFound('There is not a comment with the id: ' . $id);
    }
}
