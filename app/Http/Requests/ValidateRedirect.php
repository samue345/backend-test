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
    protected function prepareForValidation()
    {
        $parseUrl = parse_url($this->get('url_destino'));

        if (isset($parseUrl['query']) && !is_null($parseUrl['query'])) {
            parse_str($parseUrl['query'], $queryParams);

            $params = [];

            foreach ($queryParams as $key => $value) {
                $params[] = [
                    'key' => $key,
                    'value' => $value,
                ];
            }
        } else {
            $params = null;
        }

        $this->merge(['query_params' => $params]);
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
                'starts_with:https',
                'doesnt_start_with:' . config('app.url')
            ],
        ];
    }

    public function messages()
    {
        return [
            'url_destino.required' => 'O campo URL de destino é obrigatório.',
            'url_destino.url' => 'Por favor, insira uma URL válida.',
            'url_destino.starts_with' => 'A url tem que começarf com https',
            'url_destino.doesnt_start_with:' => 'A url não pode apontar pra própria aplicação.'
        ];
    }

}
