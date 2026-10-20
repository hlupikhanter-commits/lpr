<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetRequest;
use App\Models\Owner;
use App\Models\Pet;
use App\Models\Procedure;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pet::with(['owner', 'procedures']); // Жадная загрузка связей для предотвращения N+1

        // Поиск по основному строковому полю (кличка)
        if ($search = $request->query('q')) {
            $query->where('name', 'like', "%{$search}%");
        }

        // ⭐ Дополнительное задание 1: Фильтр по родителю (владелец)
        if ($request->filled('owner_id')) {
            $query->where('owner_id', $request->query('owner_id'));
        }

        // ⭐ Дополнительное задание 1: Фильтр по логическому полю (вакцинация)
        if ($request->filled('is_vaccinated')) {
            $query->where('is_vaccinated', $request->query('is_vaccinated') === '1');
        }

        // SORT: N=11 (нечётный) -> сортировка по основному строковому полю А→Я
        $query->orderBy('name', 'asc');

        // PER_PAGE = 6 (для N=11)
        $pets = $query->paginate(6)->withQueryString();

        return view('pets.index', [
            'title' => 'Питомцы',
            'pets' => $pets,
            'owners' => Owner::orderBy('full_name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pets.form', [
            'title' => 'Новый питомец',
            'pet' => new Pet(),
            'owners' => Owner::orderBy('full_name')->get(),
            'procedures' => Procedure::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PetRequest $request)
    {
        $data = $request->validated();
        $pet = Pet::create($data);

        // ⭐ M:N связь: синхронизация процедур
        if ($request->has('procedures')) {
            $pet->procedures()->sync($request->input('procedures', []));
        }

        return redirect()
            ->route('pets.index')
            ->with('status', "Добавлено: {$pet->name} (id {$pet->id})");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        $pet->load('procedures');

        return view('pets.form', [
            'title' => 'Редактирование питомца',
            'pet' => $pet,
            'owners' => Owner::orderBy('full_name')->get(),
            'procedures' => Procedure::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PetRequest $request, Pet $pet)
    {
        $data = $request->validated();
        $pet->update($data);

        // ⭐ M:N связь: синхронизация процедур
        $pet->procedures()->sync($request->input('procedures', []));

        return redirect()
            ->route('pets.index')
            ->with('status', 'Изменения сохранены.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        $name = $pet->name;
        $pet->delete();

        return redirect()
            ->route('pets.index')
            ->with('status', "Удалено: {$name}");
    }
}
