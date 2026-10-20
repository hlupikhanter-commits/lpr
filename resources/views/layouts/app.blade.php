<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Без названия' }} — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('pets.index') }}">{{ config('app.name') }}</a>
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pets.*') ? 'active fw-bold' : '' }}" href="{{ route('pets.index') }}">Питомцы (CRUD)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('owners.*') ? 'active fw-bold' : '' }}" href="{{ route('owners.index') }}">Владельцы (⭐ Родитель)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('catalog.index') ? 'active' : '' }}" href="{{ route('catalog.index') }}">Каталог (ЛПР 8)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('catalog.stats') ? 'active' : '' }}" href="{{ route('catalog.stats') }}">Статистика</a>
                </li>
            </ul>
            <a class="nav-link text-light" href="{{ route('feedback.form') }}">Обратная связь</a>
        </div>
    </nav>
    <main class="container flex-grow-1">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>
    <footer class="bg-light border-top py-3 mt-4">
        <div class="container small text-muted">
            {{ config('lab.student') }} ({{ config('lab.group') }}, N = {{ config('lab.number') }})
            · код занятия: <strong>{{ config('lab.code') }}</strong>
            · {{ now()->format('d.m.Y H:i:s') }}
        </div>
    </footer>
</body>
</html>
