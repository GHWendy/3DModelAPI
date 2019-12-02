<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRules extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data.attributes.name' => 'required|max:255',
            'data.attributes.email' => 'required|email|max:255',
            'data.attributes.password' => 'required|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return[
            'data.attributes.name.required' => 'The user name is necessary',
            'data.attributes.name.max' => 'The user name must be less or equal than 255 characters',
            'data.attributes.email.email' => 'Email format is not correct',
            'data.attributes.email.required' => 'The user email is necessary',
            'data.attributes.email.max' => 'The user email must be less or equal than 255 characters',
            'data.attributes.password.required' => 'The user password is necessary',
            'data.attributes.password.max' => 'The user password must be less or equal than 255 characters',
        ];
    }

    /**
     * Override the failedValidation() of Validator method to issue the exception with a diferent representation
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator){
        $response = ['errors' => []];
        $arrayTemp = [];
        foreach($validator->errors()->toArray() as $key => $value){
            //Form the array with a specific representacion
            $arrayTemp = [
                'code' => 'Error-6',
                'source' => $key,
                'title' => 'Unprocessable Entity',
                'detail' => $value[0],
            ];
            array_push($response['errors'], $arrayTemp);
        }
        throw new HttpResponseException(response()->json($response,422));
    }
}
