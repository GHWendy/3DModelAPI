<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Exceptions\ErrorHandler;

class CommentRequest extends FormRequest
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
            'data.attributes.title' => 'bail|required|min:5|max:80',
            'data.attributes.description' =>'max:255'
        ];
    }

    /**
     * Get the error message for the defined validation rules
     * 
     * @return array
     */
    public function messages(){
        return [
            'data.attributes.title.required' => 'The comment title is neccesary',
            'data.attributes.title.min' => 'The comment title must have at least 5 characters',
            'data.attributes.title.max' => 'The comment title shoul not have more than 80 characters',
            'data.attributes.description.max' => 'The comment description should not have more than 255 characters'
        ];
    }

     /**
     * Override the failedValidation() of Validator method to issue the exception with a diferent representation
     * 
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator){
        (new ErrorHandler())->unprocessableEntity($validator);
    }

    public function attributes(){
        return [
            'data.attributes.title' => 'title',
            'data.attributes.description' => 'description',
        ];
    }
}
