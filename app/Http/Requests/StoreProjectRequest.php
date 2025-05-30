<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'start_date' => 'required|date',
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date'
            ],
        ];
    }

    public function messages()
    {
        return [
            // Общие сообщения
            'required' => 'Поле :attribute обязательно для заполнения.',
            'string' => 'Поле :attribute должно быть строкой.',
            'max' => 'Поле :attribute не должно превышать :max символов.',
            'date' => 'Поле :attribute должно быть корректной датой.',
            
            // Конкретные сообщения для полей
            'title.required' => 'Название проекта обязательно для заполнения.',
            'title.max' => 'Название проекта не должно превышать 255 символов.',

            'description.required' => 'Описание проекта обязательно для заполнения.',
            'description.max' => 'Описание проекта не должно превышать 255 символов.',
            
            'start_date.required' => 'Дата начала проекта обязательна для заполнения.',
            'start_date.date' => 'Укажите корректную дату начала проекта.',
            'start_date.after_or_equal' => 'Дата начала не может быть в прошлом.',
            
            'end_date.required' => 'Дата окончания проекта обязательна для заполнения.',
            'end_date.date' => 'Укажите корректную дату окончания проекта.',
            'end_date.after_or_equal' => 'Дата окончания должна быть позже или равна дате начала.',
        ];
    }
}
