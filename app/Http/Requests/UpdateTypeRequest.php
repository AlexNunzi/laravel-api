<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTypeRequest extends FormRequest
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
            'name' => ['required', 'max:100', Rule::unique('types')->ignore($this->type)],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // Validator messages
            'name.required' => 'Il campo Titolo è obbligatorio.',
            'name.max' => 'Il campo Nome della tipologia può contenere un massimo di 100 caratteri',
            'name.unique' => 'Esiste già nel database una tipologia con questo nome, inserirne uno nuovo',
        ];
    }
}
