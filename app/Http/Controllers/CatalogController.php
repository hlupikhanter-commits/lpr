<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    // Временное хранилище: в ЛПР № 9 его заменит база данных
    private function pets(): array
    {
        return [
            [
                'id' => 1,
                'code' => 'VET-10001',
                'name' => 'Барсик',
                'owner' => 'Смирнов Алексей',
                'species' => 'Кот (Британский)',
                'birth_date' => '2021-04-12',
                'weight_kg' => 5.40,
                'is_vaccinated' => true,
            ],
            [
                'id' => 2,
                'code' => 'VET-10002',
                'name' => 'Рекс',
                'owner' => 'Смирнов Алексей',
                'species' => 'Собака (Овчарка)',
                'birth_date' => '2019-08-25',
                'weight_kg' => 28.50,
                'is_vaccinated' => true,
            ],
            [
                'id' => 3,
                'code' => 'VET-20001',
                'name' => 'Майло',
                'owner' => 'Иванова Елена',
                'species' => 'Собака (Джек-рассел)',
                'birth_date' => '2022-02-10',
                'weight_kg' => 6.80,
                'is_vaccinated' => false,
            ],
            [
                'id' => 4,
                'code' => 'VET-20002',
                'name' => 'Луна',
                'owner' => 'Иванова Елена',
                'species' => 'Кошка (Сфинкс)',
                'birth_date' => '2023-06-01',
                'weight_kg' => 3.20,
                'is_vaccinated' => true,
            ],
            [
                'id' => 5,
                'code' => 'VET-30001',
                'name' => 'Кеша',
                'owner' => 'Кузнецов Дмитрий',
                'species' => 'Попугай (Волнистый)',
                'birth_date' => '2024-01-15',
                'weight_kg' => 0.05,
                'is_vaccinated' => false,
            ],
            [
                'id' => 6,
                'code' => 'VET-30002',
                'name' => 'Боня',
                'owner' => 'Кузнецов Дмитрий',
                'species' => 'Кролик (Карликовый)',
                'birth_date' => '2023-11-20',
                'weight_kg' => 1.80,
                'is_vaccinated' => true,
            ],
            [
                'id' => 7,
                'code' => 'VET-40001',
                'name' => 'Персик',
                'owner' => 'Васильева Ольга',
                'species' => 'Кот (Мейн-кун)',
                'birth_date' => '2020-10-05',
                'weight_kg' => 8.90,
                'is_vaccinated' => true,
            ],
        ];
    }

    // GET /catalog?q=...&sort=...
    public function index(Request $request)
    {
        $pets = collect($this->pets());
        $search = $request->query('q');

        if ($search) {
            $pets = $pets->filter(fn ($p) => mb_stripos($p['name'], $search) !== false);
        }

        $sort = $request->query('sort', 'name');
        if (in_array($sort, ['name', 'birth_date', 'weight_kg'])) {
            $pets = $pets->sortBy($sort);
        }

        return view('catalog.index', [
            'title' => 'Каталог питомцев',
            'pets' => $pets,
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    // GET /catalog/stats (⭐ Повышенный уровень 1)
    public function stats()
    {
        $pets = collect($this->pets());
        $count = $pets->count();
        $avgWeight = round($pets->avg('weight_kg'), 2);
        $minWeight = $pets->min('weight_kg');
        $maxWeight = $pets->max('weight_kg');

        return view('catalog.stats', [
            'title' => 'Статистика питомцев',
            'count' => $count,
            'avgWeight' => $avgWeight,
            'minWeight' => $minWeight,
            'maxWeight' => $maxWeight,
        ]);
    }

    // GET /catalog/3
    public function show(int $id)
    {
        $pet = collect($this->pets())->firstWhere('id', $id);
        abort_if(! $pet, 404);

        return view('catalog.show', ['title' => $pet['name'], 'pet' => $pet]);
    }

    // GET /catalog/code/VET-10001
    public function byCode(string $code)
    {
        $pet = collect($this->pets())->firstWhere('code', $code);
        abort_if(! $pet, 404);

        return view('catalog.show', ['title' => $pet['name'], 'pet' => $pet]);
    }

    // GET /catalog/owner/Смирнов Алексей или /catalog/owner (⭐ Повышенный уровень 2)
    public function byOwner(?string $owner = null)
    {
        if (! $owner) {
            $owners = collect($this->pets())->pluck('owner')->unique();
            return view('catalog.owners', [
                'title' => 'Список владельцев',
                'owners' => $owners,
            ]);
        }

        $pets = collect($this->pets())->where('owner', $owner);

        return view('catalog.index', [
            'title' => "Питомцы владельца: {$owner}",
            'pets' => $pets,
            'search' => null,
            'sort' => 'name',
        ]);
    }
}
