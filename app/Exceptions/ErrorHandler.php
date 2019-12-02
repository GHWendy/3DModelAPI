<?php

namespace App\Exceptions;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ErrorHandler
{

    public function __construct() {

    }

    public function badRequest($message) { 
        $response = ['errors' => [
            'code' => 'ERROR-1',
            'title' => 'Bad Request',
            'detail' => $message
        ]];
        throw new HttpResponseException(response()->json($response,400));
    }

    public function unauthorized($message) {
        $response = ['errors' => [
            'code' => 'ERROR-2',
            'title' => 'Unauthorized',
            'detail' => $message
        ]];
        throw new HttpResponseException(response()->json($response,401));
    }

    public function forbidden($message) {
        $response = ['errors' => [
            'code' => 'ERROR-3',
            'title' => 'Forbidden',
            'detail' => $message
        ]];
        throw new HttpResponseException(response()->json($response,403));
    }

    public function notFound($message) {
        $response = ['errors' => [
            'code' => 'ERROR-4',
            'title' => 'Not Found',
            'detail' => $message
        ]];
        throw new HttpResponseException(response()->json($response,404));
    }

    public function teapot_Chan() {
        $response = ['errors' => [
            'code' => 'ERROR-5',
            'title' => 'We are teapots',
            'detail' => 'Pongáme 100 profe'
        ]];
        throw new HttpResponseException(response()->json($response,404));
    }

    public function unprocessableEntity(Validator $validator) {
        $response = ['errors' => []];
        $arrayTemp = [];
        foreach($validator->errors()->toArray() as $key => $value){
            //Form the array with a specific representacion
            $arrayTemp = [
                'code' => 'ERROR-6',
                'source' => $key,
                'title' => 'Unprocessable Entity',
                'detail' => $value[0],
            ];
            array_push($response['errors'], $arrayTemp);
        }
        throw new HttpResponseException(response()->json($response,422));
    }

    public function internalServerError($message) {
        $response = ['errors' => [
            'code' => 'ERROR-7',
            'title' => 'Internal Server Error',
            'detail' => $message
        ]];
        throw new HttpResponseException(response()->json($response,500));
    }

    public function notImplemented($message) {
        $response = ['errors' => [
            'code' => 'ERROR-8',
            'title' => 'Not Implemented',
            'detail' => $message
        ]];
        throw new HttpResponseException(response()->json($response,501));
    }
}