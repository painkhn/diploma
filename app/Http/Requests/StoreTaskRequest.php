<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'end_date' => 'required|date|after_or_equal:today',
            'responsible_id' => 'required|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле :attribute обязательно для заполнения.',
            'string' => 'Поле :attribute должно быть строкой.',
            'max' => 'Поле :attribute не должно превышать :max символов.',
            'date' => 'Поле :attribute должно быть корректной датой.',
            'after_or_equal' => 'Поле :attribute должно быть датой после или равной сегодняшнему дню.',
            'exists' => 'Выбранный :attribute не существует.',
            
            // Специфические сообщения
            'end_date.after_or_equal' => 'Дата окончания не может быть в прошлом.',
            'responsible_id.required' => 'Необходимо выбрать ответственного.',
        ];
    }
}
