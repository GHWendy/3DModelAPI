<?php

namespace App\Exceptions;

use Exception;
use Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\QueryException;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        
        if ($exception instanceof AuthenticationException) {
            $response = ['errors' => 
                [
                    'code' => 'ERROR-2',
                    'title' => 'Unauthorized',
                    'detail' => 'You need to authenticate'
                ]
            ];
            return response()->json($response, 401);
        }
        else if ($exception instanceof AuthorizationException) {
            $response = ['errors' => 
                [
                    'code' => 'ERROR-3',
                    'title' => 'Forbidden',
                    'detail' => $exception->getMessage()
                ]
            ];
            return response()->json($response, 403);
            //return Response::json($response, JsonResponse::HTTP_FORBIDDEN);
        }else if ($exception instanceof NotFoundHttpException) {
            $response = ['errors' => 
                [
                    'code' => 'ERROR-4',
                    'title' => 'Not found',
                    'detail' => $exception->getMessage() != null ? $exception->getMessage() : 'The requested resource was not found'
                ]
            ];
            return response()->json($response, 404);
        }/*else if($exception instanceof QueryException) {
            $response = ['errors' => [
                'code' => 'ERROR-1',
                'title' => 'Bad request',
                'detail' => "There was an error in your request"
            ]];
            return response()->json($response, 400);
        }*/
        /*else {
            $response = ['errors' => 
                [
                    'code' => 'ERROR-7',
                    'title' => 'Internal Server Error',
                    'detail' => 'Upsi dupsi, there was an error on the server. :s'
                ]
            ];
            return response()->json($response, 500);
        }*/
    
        

        //return Response::json([(array) $exception], JsonResponse::HTTP_UNAUTHORIZED);
        //return response()->json([get_class($exception)], 500);
        return parent::render($request, $exception);
    }
}
