<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateRedirect extends FormRequest
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
     * @return array<string, mixed>
     */

     
    public function rules()
    {
        return [

            'url_destino' => [
                'required',
                'url',
                'regex:/^https:/',
                function ($attribute, $value, $fail) {
                    $appUrl = config('app.url');
                    if (strpos($value, $appUrl) === 0) 
                        $fail('A URL de destino não pode apontar para a própria aplicação.');
                },
                
            ],
        ];
    }

    public function messages()
    {
        return [
            'url_destino.required' => 'O campo URL de destino é obrigatório.',
            'url_destino.regex' => 'A url tem que começar com https',
            'url_destino' => 'A url não pode apontar pra própria aplicação.',
            
        ];
    }

}
