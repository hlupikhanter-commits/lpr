@extends('layouts.app')

@section('content')
    <h1 class="mb-3">{{ $title }}</h1>
    <p class="text-muted">Выберите владельца для просмотра списка его питомцев:</p>
    <div class="list-group col-md-6 mb-4">
        @foreach ($owners as $owner)
            <a href="{{ route('catalog.owner', ['owner' => $owner]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <span>{{ $owner }}</span>
                <span class="badge bg-primary rounded-pill">&rarr;</span>
            </a>
        @endforeach
    </div>
    <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary">&larr; К полному каталогу</a>
@endsection
