<?php

namespace Database\Factories;

use App\Models\Owner;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    protected $model = Pet::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $petNames = [
            'Арчи', 'Барон', 'Барсик', 'Белла', 'Боня', 'Бублик', 'Герда', 'Грей',
            'Джек', 'Зевс', 'Кузя', 'Купер', 'Локи', 'Люси', 'Макс', 'Марсик',
            'Мурка', 'Оскар', 'Персик', 'Рекс', 'Симба', 'Снежок', 'Тайсон', 'Тоби',
            'Чарли', 'Шарик', 'Алмаз', 'Байкал', 'Вулкан', 'Граф', 'Дымка', 'Жужа',
        ];

        return [
            'owner_id' => Owner::factory(),
            'name' => fake()->unique()->randomElement($petNames) . ' ' . fake()->unique()->numberBetween(1, 999),
            'description' => fake()->optional(0.7)->realText(120),
            'species' => fake()->randomElement(['Собака', 'Кошка', 'Кролик', 'Хомяк', 'Попугай', 'Енот', 'Хорёк']),
            'birth_date' => fake()->dateTimeBetween('-12 years', '-2 months')->format('Y-m-d'),
            'weight_kg' => fake()->randomFloat(2, 0.5, 45.0),
            'is_vaccinated' => fake()->boolean(70),
        ];
    }
}
