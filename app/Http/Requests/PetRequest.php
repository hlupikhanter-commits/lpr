<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PetRequest extends FormRequest
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
        $petId = $this->route('pet')?->id;

        return [
            'owner_id' => ['required', 'integer', 'exists:owners,id'],
            'name' => [
                'required',
                'string',
                'min:4', // MIN_LEN = 4 (N=11)
                'max:133', // STR_LEN = 133 (N=11)
                Rule::unique('pets')
                    ->where('owner_id', $this->input('owner_id'))
                    ->ignore($petId),
            ],
            'description' => ['nullable', 'string', 'max:2000'],
            'species' => ['required', 'string', 'min:2', 'max:50'],
            'birth_date' => ['required', 'date', 'before_or_equal:today'],
            'weight_kg' => ['required', 'numeric', 'between:0.01,300.00'],
            'is_vaccinated' => ['boolean'],
            // ⭐ M:N связь с процедурами
            'procedures' => ['nullable', 'array'],
            'procedures.*' => ['integer', 'exists:procedures,id'],
        ];
    }

    /**
     * Custom validation messages in Russian.
     */
    public function messages(): array
    {
        return [
            'required' => 'Поле «:attribute» обязательно для заполнения.',
            'name.min' => 'Кличка питомца должна содержать не менее :min символов.',
            'name.max' => 'Кличка питомца не должна превышать :max символов.',
            'name.unique' => 'У данного владельца уже зарегистрирован питомец с такой кличкой.',
            'owner_id.exists' => 'Выбранный владелец не существует в базе данных.',
            'species.min' => 'Вид животного должен содержать не менее :min символов.',
            'birth_date.before_or_equal' => 'Дата рождения не может быть позже сегодняшнего дня.',
            'weight_kg.between' => 'Вес питомца должен быть в диапазоне от :min до :max кг.',
            'weight_kg.numeric' => 'Вес питомца должен быть числовым значением.',
            'procedures.*.exists' => 'Выбранная процедура не найдена в базе данных.',
        ];
    }

    /**
     * Russian attribute names.
     */
    public function attributes(): array
    {
        return [
            'owner_id' => 'Владелец',
            'name' => 'Кличка',
            'description' => 'Описание',
            'species' => 'Вид животного',
            'birth_date' => 'Дата рождения',
            'weight_kg' => 'Вес (кг)',
            'is_vaccinated' => 'Вакцинирован',
            'procedures' => 'Процедуры',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_vaccinated' => $this->boolean('is_vaccinated'),
        ]);
    }
}
