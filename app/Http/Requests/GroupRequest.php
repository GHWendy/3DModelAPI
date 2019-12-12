<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Exceptions\ErrorHandler;


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
        $figuresRequest= $request->data['attributes']['figures']

        $rules = ['data.attributes.*.members' => Rule::unique('users_groups')->where(function ($query) use ($request) {
                                                    return $query ->where('user_id',$value) ->where('group_id',$id);}),

                'data.attributes.*.figures' => Rule::unique('figures_groups')->where(function ($query) use ($request) {
                                                    return $query ->where('figure_id',$value) ->where('group_id',$id);})
                ];

        switch ($this-> method()) {
            case 'POST':

            $rules = [
                'data.attributes.name' => 'bail|required',
                'data.attributes.description' => 'bail|max:300',
                'data.attributes.*.members' => 'exists: users, id',
                'data.atributes.*.figures' => 'exists: figures,id',
                
            ];
                break;   
            case 'PUT': 
                $rules = [
                // 'data.attributes.*.members' => 

                // 'data.atributes.*.figures' => 'unique: figures_groups,id',

               ];
                break;         
            default:
                break;
        }

        return $rules;
    }

    public function messages()
    {
         $errorMessages = [
            'data.attributes.name' => 'The group :attribute is necessary',
            'data.attributes.description.required' => 'A description is necessary',            
            'data.attributes.description.max' => 'The :attribute must be max :max words',
            'data.attributes.*.members.exist' => 'Please, enter valid user(s)',
            'data.atributes.*.figures.exists' => 'The figure(s) does not exist(s)' ,
         ];
        return $errorMessages;
    }

    protected function failedValidation(Validator $validator){
        (new ErrorHandler())->unprocessableEntity($validator);
    }
}
