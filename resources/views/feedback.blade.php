@extends('layouts.app')

@section('content')
    <h1 class="mb-3">{{ $title }}</h1>
    <form method="POST" action="{{ route('feedback.send') }}" class="col-md-6">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Ваше имя">
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Сообщение</label>
            <textarea id="message" name="message" class="form-control" rows="3" placeholder="Ваше сообщение"></textarea>
        </div>
        <button class="btn btn-primary">Отправить</button>
    </form>
@endsection
