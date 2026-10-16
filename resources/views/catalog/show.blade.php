@extends('layouts.app')

@section('content')
    <h1 class="mb-4">{{ $pet['name'] }}</h1>
    <div class="card col-md-8 mb-4">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $pet['id'] }}</dd>

                <dt class="col-sm-3">Код</dt>
                <dd class="col-sm-9"><span class="badge bg-dark font-monospace">{{ $pet['code'] }}</span></dd>

                <dt class="col-sm-3">Кличка</dt>
                <dd class="col-sm-9"><strong>{{ $pet['name'] }}</strong></dd>

                <dt class="col-sm-3">Владелец</dt>
                <dd class="col-sm-9">
                    <a href="{{ route('catalog.owner', ['owner' => $pet['owner']]) }}">{{ $pet['owner'] }}</a>
                </dd>

                <dt class="col-sm-3">Биологический вид</dt>
                <dd class="col-sm-9">{{ $pet['species'] }}</dd>

                <dt class="col-sm-3">Дата рождения</dt>
                <dd class="col-sm-9">{{ \Carbon\Carbon::parse($pet['birth_date'])->format('d.m.Y') }}</dd>

                <dt class="col-sm-3">Вес</dt>
                <dd class="col-sm-9">{{ number_format($pet['weight_kg'], 2, ',', ' ') }} кг</dd>

                <dt class="col-sm-3">Вакцинация</dt>
                <dd class="col-sm-9">
                    @if ($pet['is_vaccinated'])
                        <span class="badge bg-success">Вакцинирован</span>
                    @else
                        <span class="badge bg-secondary">Не вакцинирован</span>
                    @endif
                </dd>
            </dl>
        </div>
    </div>
    <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary">&larr; К каталогу</a>
@endsection
