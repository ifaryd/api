<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class TypeStoreRequest extends FormRequest
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
            'libelle' => ['required', 'min:4', 'max:255', Rule::unique('types')->ignore($request->id)],
            'description' => 'nullable|max:255',
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
          'libelle.unique' => "Libellé existe déjä",
          'description.max' => "la description doit avoir au maximum 255 caractères",
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
