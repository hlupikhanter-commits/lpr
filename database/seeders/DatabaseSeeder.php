<?php

namespace Database\Seeders;

use App\Models\Owner;
use App\Models\Pet;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // PARENTS = 5 (по формуле для N=11)
        $owners = Owner::factory()->count(5)->create();

        // SEED = 23 (по формуле для N=11)
        Pet::factory()
            ->count(23)
            ->recycle($owners)
            ->create();
    }
}
