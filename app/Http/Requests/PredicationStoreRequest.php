<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class PredicationStoreRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $predictions = [
            'titre' => ['required', 'min:4', 'max:255', Rule::unique('predications')->ignore($request->id)],
            'sous_titre' => 'required',
            'numero' => 'required|integer',
            'lien_audio' => 'nullable',
            'nom_audio' => 'nullable',
            'lien_video' => 'nullable',
            'duree' => 'nullable',
            'chapitre' => 'required|min:4|max:225',
            'couverture' => 'nullable',
            'sermon_similaire' => 'nullable',
            'langue_id' => 'required'
        ];

        return $predictions;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'titre.required' => "Le titre est requis",
            'numero.required' => "Le numéro est requis",
            'chapitre.required' => "Le chapitre est requis",
            'langue_id.required' => "La langue est requise"
        ];
    }

    /*** Get the error messages for the defined validation rules.** @return array*/
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json($validator->errors(), 422)
        );
    }
}
