<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class PaysStoreRequest extends FormRequest
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
            'langue_id' => ['required', 'integer'],
            'principal' => ['nullable', 'boolean'],
            'nom' => ['required', 'min:4', 'max:255', Rule::unique('pays')->ignore($request->id)],
            'sigle' => ['required', 'max:255', Rule::unique('pays')->ignore($request->id)],
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
          'nom.required' => "Nom est requis",
          'sigle.required' => "Sigle est requis",
          'sigle.unique' => "Sigle existe déjä",
          'nom.unique' => "Nom existe déjä",
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
