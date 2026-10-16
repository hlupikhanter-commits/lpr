@extends('layouts.app')

@section('content')
    <h1 class="mb-3">{{ $title }}</h1>

    <form method="GET" action="{{ route('catalog.index') }}" class="row g-2 mb-3">
        <div class="col-auto">
            <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Поиск по кличке...">
        </div>
        <div class="col-auto">
            <select name="sort" class="form-select">
                <option value="name" @selected($sort === 'name')>По кличке</option>
                <option value="birth_date" @selected($sort === 'birth_date')>По дате рождения</option>
                <option value="weight_kg" @selected($sort === 'weight_kg')>По весу</option>
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-secondary">Найти</button>
        </div>
        @if ($search || $sort !== 'name')
            <div class="col-auto">
                <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary">Сбросить</a>
            </div>
        @endif
    </form>

    <table class="table table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>№</th>
                <th>Кличка</th>
                <th>Владелец</th>
                <th>Вид</th>
                <th>Дата рождения</th>
                <th>Вакцинация</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pets as $pet)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><a href="{{ route('catalog.show', ['id' => $pet['id']]) }}" class="fw-bold">{{ $pet['name'] }}</a></td>
                    <td><a href="{{ route('catalog.owner', ['owner' => $pet['owner']]) }}">{{ $pet['owner'] }}</a></td>
                    <td>{{ $pet['species'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($pet['birth_date'])->format('d.m.Y') }}</td>
                    <td>
                        @if ($pet['is_vaccinated'])
                            <span class="badge bg-success">Привит</span>
                        @else
                            <span class="badge bg-secondary">Не привит</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-muted text-center py-3">Ничего не найдено.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
