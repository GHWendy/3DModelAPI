<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Exceptions\ErrorHandler;

class FigureRules extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'data.attributes.name' => 'required',
                    'data.attributes.image_preview' => 'url',
                    'data.attributes.description' => 'bail|max:300',
                    'data.attributes.dimensions.x' => 'bail|required|numeric|gt:0',
                    'data.attributes.dimensions.y' => 'bail|required|numeric|gt:0',
                    'data.attributes.dimensions.z' => 'bail|required|numeric|gt:0',
                    'data.attributes.difficulty' => ['bail', 'required', Rule::in(['easy', 'normal', 'hard'])],
                    'data.attributes.glb_download' => 'bail|required|url',
                    'data.attributes.type' => ['bail', 'required', Rule::in(['private', 'public'])],
                ];
            case 'PUT':
                return [
                    'data.attributes.name' => 'sometimes|required',
                    'data.attributes.image_preview' => 'sometimes|url',
                    'data.attributes.description' => 'bail|sometimes|max:300',
                    'data.attributes.dimensions.x' => 'bail|sometimes|required|numeric|gt:0',
                    'data.attributes.dimensions.y' => 'bail|sometimes|required|numeric|gt:0',
                    'data.attributes.dimensions.z' => 'bail|sometimes|required|numeric|gt:0',
                    'data.attributes.difficulty' => ['sometimes', 'bail', 'required', Rule::in(['easy', 'normal', 'hard'])],
                    'data.attributes.glb_download' => 'bail|sometimes|required|url',
                    'data.attributes.type' => ['bail', 'sometimes', 'required', Rule::in(['private', 'public'])],
                ];
        }
        return [
            'data.attributes.name' => 'required',
            'data.attributes.image_preview' => 'url',
            'data.attributes.description' => 'bail|max:300',
            'data.attributes.dimensions.x' => 'bail|required|numeric|gt:0',
            'data.attributes.dimensions.y' => 'bail|required|numeric|gt:0',
            'data.attributes.dimensions.z' => 'bail|required|numeric|gt:0',
            'data.attributes.difficulty' => ['bail', 'required', Rule::in(['easy', 'normal', 'hard'])],
            'data.attributes.glb_download' => 'bail|required|url',
            'data.attributes.type' => ['bail', 'required', Rule::in(['private', 'public'])],
        ];
    }

    /**
     * Get the error message for the defined validation rules
     * 
     * @return array
     */
    public function messages(){
        return [
            'data.attributes.name.required' => 'The 3D model name is necessary',
            'data.attributes.image_preview.url' => 'The image preview should be an URL',
            'data.attributes.description.max' => 'The 3D model description should be less than or equal to 300 characters',
            'data.attributes.dimensions.x.required' => 'The "x" dimension of the 3D model is necessary',
            'data.attributes.dimensions.y.required' => 'The "y" dimension of the 3D model is necessary',
            'data.attributes.dimensions.z.required' => 'The "z" dimension of the 3D model is necessary',
            'data.attributes.dimensions.x.numeric' => 'The "x" dimension of the 3D model should be numeric',
            'data.attributes.dimensions.y.numeric' => 'The "y" dimension of the 3D model should be numeric',
            'data.attributes.dimensions.z.numeric' => 'The "z" dimension of the 3D model should be numeric',
            'data.attributes.dimensions.x.gt' => 'The "x" dimension of the 3D model should be greater than zero',
            'data.attributes.dimensions.y.gt' => 'The "y" dimension of the 3D model should be greater than zero',
            'data.attributes.dimensions.z.gt' => 'The "z" dimension of the 3D model should be greater than zero',
            'data.attributes.difficulty.required' => 'The 3D model level of difficulty is necessary',
            'data.attributes.glb_download.url' => 'The glb_download should be an URL',
            'data.attributes.difficulty.type' => 'The 3D model type is necessary',
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
            'data.attributes.name' => 'name',
            'data.attributes.image.preview' => 'image_preview',
            'data.attributes.description' => 'description',
            'data.attributes.dimensions.x' => 'x',
            'data.attributes.dimensions.y' => 'y',
            'data.attributes.dimensions.z' => 'z',
            'data.attributes.difficulty' => 'difficulty',
            'data.attributes.glb_download' => 'glb_download',
            'data.attributes.type' => 'type',
        ];
    }
}
