<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class AssembleeStoreRequest extends FormRequest
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
            'nom' => ['required', 'min:4', 'max:255', Rule::unique('assemblees')->ignore($request->id)],
            'photo' => 'nullable|max:255',
            'addresse' => 'required|max:255',
            'localisation' => 'nullable',
            'ville_id' => 'required|integer',
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
          'ville_id.required' => "ville est requis",
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
