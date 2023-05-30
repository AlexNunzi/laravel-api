<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            // Validator rules
            'title' => 'required|max:150|unique:projects',
            'start_date' => 'required',
            'end_date' => 'nullable',
            'description' => 'nullable|max:65535',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'exists:technologies,id',
            'preview_img' => 'nullable|image|max:1024'
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
            'title.required' => 'Il campo Titolo è obbligatorio.',
            'title.max' => 'Il campo Titolo può contenere un massimo di 150 caratteri',
            'title.unique' => 'Esiste già nel database un progetto con questo nome, inserirne uno nuovo',
            'start_date' => 'Il campo Data di inizio è obbligatorio',
            'description.max' => 'Il campo description può contenere un massimo di 65535 caratteri',
            'type_id.exists' => 'La categoria selezionata non esiste',
            'technologies.exists' => 'La tecnologia selezionata non esiste',
            'preview_img.image' => 'Il file caricato deve necessariamente essere un\'immagine di un formato accettabile (jpg, jpeg, png, bmp, gif, svg, webp)',
            'preview_img.max' => 'Il file caricato può avere una dimensione massima pari a 1MB'
        ];
    }
}
