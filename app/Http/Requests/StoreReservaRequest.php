<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sede_stand_id' => [
                'required', 'integer', 'exists:sede_stands,id'
            ],
            'reservation_date' => [
                'required', 'date', 'after_or_equal:today'
            ],
            'name' => [
                'required', 'string', 'min:3','max:50'
            ],
            'surname' => [
                'required', 'string', 'min:3', 'max:50'
            ],
            'email' => [
                'required', 'email', 'max:60'
            ],
            'phone' => [
                'required', 'string', 'max:20','regex:/^[0-9]{9}$/'
            ],
            'termsCheck' => 'accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'sede_stand_id.required' => 'Debe seleccionar un stand.',
            'sede_stand_id.exists' => 'El stand seleccionado no existe.',
            'reservation_date.required' => 'Debe seleccionar una fecha válida.',
            'reservation_date.after_or_equal' => 'La fecha debe ser igual o posterior a hoy.',
            'name.required' => 'El nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre debe tener máximo 50 caracteres.',
            'surname.required' => 'El apellido es obligatorio.',
            'surname.min' => 'El apellido debe tener al menos 3 caracteres.',
            'surname.max' => 'El apellido debe tener máximo 50 caracteres.',
            'phone.required' => 'El teléfono es obligatorio.',
            'phone.regex' => 'El teléfono debe contener 9 dígitos numéricos.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo válido.',
            'termsCheck.accepted' => 'Debe aceptar los términos y condiciones.',
        ];
    }
}
