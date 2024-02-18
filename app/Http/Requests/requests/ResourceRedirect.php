<?php

namespace App\Http\Requests\requests;

use Illuminate\Foundation\Http\FormRequest;

class ResourceRedirect extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'required',
            'url',
            'starts_with:https',
            'doesnt_start_with:' . config('app.url')

        ];
    }
}
