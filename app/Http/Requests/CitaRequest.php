<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CitaRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'service' => 'required|string|max:255',
            'fecha_cita' => 'required|date|after_or_equal:today',
            'hora_cita' => 'required|date_format:H:i',
        
            // Solo obligatorios si marcó "domicilio"
            'calle' => 'required_if:domicilio,1|nullable|string|max:255',
            'entre_calles' => 'nullable|string|max:255',
            'edificio' => 'nullable|string|max:255',
            'apartamento' => 'nullable|string|max:50',
            'reparto' => 'required_if:domicilio,1|nullable|string|max:255',
            'municipio' => 'required_if:domicilio,1|nullable|string|max:255',
        ];            
    }

    public function messages(): array
{
    return [
        'calle.required_if' => 'Indica la calle para el servicio a domicilio.',
        'reparto.required_if' => 'Indica el reparto para el servicio a domicili',
        'municipio.required_if' => 'Indica el municipio para el servicio a domi'
    ];
}

public function withValidator(CitaRequest $validator): void
{
    $validator->after(function (CitaRequest $validator) {
        if ($this->filled('fecha_cita') && $this->filled('hora_cita')) {
            if (!CitaRequest::horarioDisponible($this->fecha_cita, $this->hora_cita)) {
                $validator->errors()->add('hora_cita', 'Ese horario ya está reservado, por favor elige otro.');
            }
        }
    });
}
}
