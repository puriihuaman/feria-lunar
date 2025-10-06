<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:50',
            'surname' => 'required|string|min:3|max:50',
            'phone' => 'required|regex:/^[0-9]{9}$/',
            'email' => 'required|email|max:60',
            'sede_stand_id' => 'required|exists:stands,id',
            'reservation_date' => 'required|date',
            'termsCheck' => 'accepted', // Valida que haya marcado términos
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'surname.required' => 'El apellido es obligatorio.',
            'phone.required' => 'El teléfono es obligatorio.',
            'phone.regex' => 'El teléfono debe contener 9 dígitos numéricos.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo válido.',
            'sede_stand_id.required' => 'Debe seleccionar un stand.',
            'sede_stand_id.exists' => 'El stand seleccionado no existe.',
            'reservation_date.required' => 'Debe seleccionar una fecha válida.',
            'termsCheck.accepted' => 'Debe aceptar los términos y condiciones.',
        ];
    }
}
