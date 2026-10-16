@extends('layouts.app')

@section('content')
    <h1 class="mb-4">{{ $title }}</h1>
    <div class="row g-4 col-md-8 mb-4">
        <div class="col-sm-6">
            <div class="card text-center p-3 shadow-sm border-primary">
                <div class="text-muted mb-1">Всего питомцев</div>
                <div class="display-6 fw-bold text-primary">{{ $count }}</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card text-center p-3 shadow-sm border-info">
                <div class="text-muted mb-1">Средний вес</div>
                <div class="display-6 fw-bold text-info">{{ number_format($avgWeight, 2, ',', ' ') }} кг</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card text-center p-3 shadow-sm border-warning">
                <div class="text-muted mb-1">Минимальный вес</div>
                <div class="display-6 fw-bold text-warning">{{ number_format($minWeight, 2, ',', ' ') }} кг</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card text-center p-3 shadow-sm border-success">
                <div class="text-muted mb-1">Максимальный вес</div>
                <div class="display-6 fw-bold text-success">{{ number_format($maxWeight, 2, ',', ' ') }} кг</div>
            </div>
        </div>
    </div>
    <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary">&larr; К каталогу</a>
@endsection
