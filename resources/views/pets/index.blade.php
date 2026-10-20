@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ $title }}</h1>
        <a href="{{ route('pets.create') }}" class="btn btn-success">+ Добавить питомца</a>
    </div>

    <!-- Форма поиска и фильтрации -->
    <form method="GET" action="{{ route('pets.index') }}" class="row g-2 mb-4 p-3 bg-light rounded border align-items-end">
        <div class="col-md-3">
            <label class="form-label small text-muted">Поиск по кличке:</label>
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Например: Барсик">
        </div>
        <div class="col-md-3">
            <label class="form-label small text-muted">Владелец:</label>
            <select name="owner_id" class="form-select">
                <option value="">Все владельцы</option>
                @foreach ($owners as $owner)
                    <option value="{{ $owner->id }}" @selected(request('owner_id') == $owner->id)>
                        {{ $owner->full_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small text-muted">Вакцинация:</label>
            <select name="is_vaccinated" class="form-select">
                <option value="">Все</option>
                <option value="1" @selected(request('is_vaccinated') === '1')>Вакцинирован</option>
                <option value="0" @selected(request('is_vaccinated') === '0')>Не вакцинирован</option>
            </select>
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-grow-1">Найти</button>
            <a href="{{ route('pets.index') }}" class="btn btn-outline-secondary">Сбросить</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Кличка</th>
                    <th>Владелец</th>
                    <th>Вид</th>
                    <th>Дата рождения</th>
                    <th>Вес</th>
                    <th>Вакцинация</th>
                    <th class="text-end">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pets as $pet)
                    <tr>
                        <td>{{ $pet->id }}</td>
                        <td>
                            <strong>{{ $pet->name }}</strong>
                            @if ($pet->description)
                                <div class="small text-muted text-truncate" style="max-width: 250px;" title="{{ $pet->description }}">
                                    {{ $pet->description }}
                                </div>
                            @endif
                        </td>
                        <td>
                            {{ $pet->owner->full_name }}
                            <div class="small text-muted">{{ $pet->owner->phone }}</div>
                        </td>
                        <td><span class="badge bg-secondary">{{ $pet->species }}</span></td>
                        <td>{{ $pet->birth_date?->format('d.m.Y') }}</td>
                        <td>{{ $pet->weight_kg }} кг</td>
                        <td>
                            @if ($pet->is_vaccinated)
                                <span class="badge bg-success">Вакцинирован</span>
                            @else
                                <span class="badge bg-warning text-dark">Нет прививки</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('pets.edit', $pet) }}" class="btn btn-sm btn-outline-primary">Изменить</a>
                            <form method="POST" action="{{ route('pets.destroy', $pet) }}" class="d-inline"
                                  onsubmit="return confirm('Вы уверены, что хотите удалить запись «{{ $pet->name }}»?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Питомцы не найдены. Попробуйте изменить параметры поиска.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Пагинация с сохранением параметров строки запроса -->
    <div class="mt-3 d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Показано с {{ $pets->firstItem() ?? 0 }} по {{ $pets->lastItem() ?? 0 }} из {{ $pets->total() }} записей (по {{ $pets->perPage() }} на стр.)
        </div>
        <div>
            {{ $pets->links() }}
        </div>
    </div>
@endsection
