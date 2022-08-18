<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class LangueStoreRequest extends FormRequest
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
            'pays_id' => ['required', 'integer'],
            'principal' => ['nullable', 'boolean'],
            'initial' => ['required', 'max:255', Rule::unique('langues')->ignore($request->id)],
            'libelle' => ['required', 'max:255', Rule::unique('langues')->ignore($request->id)],
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
          'libelle.required' => "Libellé est requis",
          'initial.required' => "Initial est requis",
          'libelle.unique' => "Libellé existe déjä",
          'initial.unique' => "Initial existe déjä",
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
