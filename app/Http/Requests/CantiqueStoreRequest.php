<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class CantiqueStoreRequest extends FormRequest
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
        return [
            'titre' => ['required', 'min:4', 'max:255', Rule::unique('cantiques')->ignore($request->id)],
            'lien_audio' => 'required',
            'contenu' => '',
            'duree' => 'required|integer',
            'user_id' => 'required|integer',
            'langue_id' => 'nullable|integer',
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
          'titre.required' => "titre est requis",
          'lien_audio.required' => "lien_audio est requis",
          'contenu.required' => "contenu est requis",
          'duree.required' => "duree est requis",
          'user_id.required' => "chantre est requis",
          'langue_id.required' => "langue est requis",
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
