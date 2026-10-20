<?php

namespace Database\Seeders;

use App\Models\Owner;
use App\Models\Pet;
use App\Models\Procedure;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Базовый справочник процедур (для связи M:N)
        $procedures = collect([
            ['name' => 'Вакцинация комплексная', 'price' => 1500.00],
            ['name' => 'Электронное чипирование', 'price' => 1200.00],
            ['name' => 'Первичный терапевтический осмотр', 'price' => 800.00],
            ['name' => 'Ультразвуковая чистка зубов', 'price' => 2500.00],
            ['name' => 'Гигиеническая стрижка когтей', 'price' => 450.00],
            ['name' => 'Противопаразитарная обработка', 'price' => 600.00],
        ])->map(fn ($p) => Procedure::firstOrCreate(['name' => $p['name']], $p));

        // PARENTS = 5 (по формуле для N=11)
        $owners = Owner::factory()->count(5)->create();

        // SEED = 23 (по формуле для N=11)
        $pets = Pet::factory()
            ->count(23)
            ->recycle($owners)
            ->create();

        // Назначим процедуры некоторым питомцам
        foreach ($pets as $pet) {
            $randomProcedures = $procedures->random(rand(0, 3))->pluck('id');
            $pet->procedures()->sync($randomProcedures);
        }
    }
}
