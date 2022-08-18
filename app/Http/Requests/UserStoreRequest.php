<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserStoreRequest extends FormRequest
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
        'email' => 'nullable|min:4|max:100|email:rfc',
        'password' => 'nullable|min:8|max:20',
        'first_name' => 'required',
        'last_name' => 'required',
        'telephone' => 'nullable',
        'facebook' => 'nullable',
        'youtube' => 'nullable',
        "charge_id" => 'nullable',
        "pays_id" => 'nullable',
        "assemblee_id" => 'nullable',
        "position_chantre" => 'nullable',
        "principal" => 'nullable',
        'avatar' => 'nullable|string',
        'updated_at' => 'nullable|date',
        'created_at' => 'nullable|date',
        'deleted_at' => 'nullable|date'
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
          'email.unique' => "Cette addresse e-amil existe déjä",
          'email.min' => "L'addresse e-amil doit avoir au minimum 4 caractères",
          'email.max' => "L'addresse e-amil doit avoir au maximum 20 caractères",
          'password.min' => "Le mot de passe doit avoir au minimum 8 caractères",
          'password.max' => "Le mot de passe doit avoir au maximum 20 caractères",
          'first_name.required' => "Le nom est réquis",
          'last_name.required' => "Le prenom est réquis",
          'created_at.date' => "Le format de la date est incorrècte",
          'updated_at.date' => "Le format de la date est incorrècte",
          'deleted_at.date' => "Le format de la date est incorrècte",
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
