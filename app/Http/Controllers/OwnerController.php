<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Список владельцев с количеством питомцев (withCount)
     */
    public function index()
    {
        $owners = Owner::withCount('pets')->orderBy('full_name')->get();

        return view('owners.index', [
            'title' => 'Владельцы питомцев',
            'owners' => $owners,
        ]);
    }

    /**
     * Создание нового владельца
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|min:3|max:150',
            'phone' => 'required|string|min:5|max:30',
        ], [
            'required' => 'Поле «:attribute» обязательно для заполнения.',
            'min' => 'Поле «:attribute» должно быть не короче :min символов.',
        ], [
            'full_name' => 'ФИО владельца',
            'phone' => 'Номер телефона',
        ]);

        $owner = Owner::create($validated);

        return redirect()->route('owners.index')->with('status', "Владелец «{$owner->full_name}» успешно добавлен.");
    }

    /**
     * Удаление владельца по правилам ON_DELETE
     */
    public function destroy(Owner $owner)
    {
        try {
            $name = $owner->full_name;
            $petsCount = $owner->pets()->count();

            // В нашей предметной области для N=11 действует ON_DELETE CASCADE:
            // При удалении родителя удаляются и все его питомцы
            $owner->delete();

            return redirect()->route('owners.index')
                ->with('status', "Владелец «{$name}» и все его питомцы ({$petsCount} шт.) успешно удалены (действие ON DELETE CASCADE).");
        } catch (QueryException $e) {
            // Перехват исключения на случай, если бы действовал RESTRICT
            return redirect()->route('owners.index')
                ->with('error', "Невозможно удалить владельца: имеются связанные питомцы (RESTRICT). Ошибка: " . $e->getMessage());
        }
    }
}
