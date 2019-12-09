<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
         $rules = [
            'data.attributes.name' => 'bail|required',
            'data.attributes.description' => 'bail|required|max:300'
            //TODO: Add members and figures 
         ];
        return $rules;
    }

    public function messages()
    {
         $errorMessages = [
            'data.attributes.name' => 'The group :attribute is necessary',
            'data.attributes.description.required' => 'A description is necessary',            
            'data.attributes.description.max' => 'The :attribute must be max :max words',
            //TODO: Add members and figures 
         ];
        return $errorMessages;
    }

    protected function failedValidation(Validator $validator){
        /*$errHand = new ErrorHandler();
        $errHand->unprocessableEntity($validator);*/
        (new ErrorHandler())->unprocessableEntity($validator);
    }

    public function attributes(){
        return [
            'data.attributes.name' => 'name',
            'data.attributes.description' => 'description',            
            // 'data.attributes.members' => 'members',
            // 'data.attributes.figures' => 'figures'
             //TODO: Add members and figures 
        ];
    }
}
