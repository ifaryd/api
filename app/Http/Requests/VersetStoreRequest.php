<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class VersetStoreRequest extends FormRequest
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
            'info' => 'nullable',
            'predication_id' => 'required|max:255',
            'numero' => ['required', 'integer', Rule::unique('versets')->ignore($request->id)],
            'contenu' => ['required', Rule::unique('versets')->ignore($request->contenu)]
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
            'numero.required' => "Le numéro du verset est requis",
            'contenu.required' => "Contenu est requis",
            'predication_id.required' => "L'ID de la predication est requis",
            'numero.unique' => "Le numéro existe déjä",
            'contenu.unique' => "Contenu existe déjä",
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
