@extends('layouts.app')

@php
    $title = '404 — Страница не найдена';
@endphp

@section('content')
    <div class="py-5 text-center">
        <h1 class="display-1 text-danger fw-bold">404</h1>
        <h2 class="h3 mb-3">Страница не найдена</h2>
        <p class="lead text-muted">
            Запрошенный путь <code>/{{ request()->path() }}</code> не найден на сервере.
        </p>
        <a href="{{ route('catalog.index') }}" class="btn btn-primary mt-3">&larr; Вернуться в каталог</a>
    </div>
@endsection
