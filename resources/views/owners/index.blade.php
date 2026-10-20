@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>{{ $title }}</h1>
            <p class="text-muted mb-0">Управление родительскими записями (Владельцы). Правило ON_DELETE: <strong>CASCADE</strong>.</p>
        </div>
        <button class="btn btn-success" data-bs-toggle="collapse" data-bs-target="#addOwnerForm">
            + Новый владелец
        </button>
    </div>

    <!-- Форма быстрого добавления владельца -->
    <div class="collapse mb-4" id="addOwnerForm">
        <div class="card card-body bg-light">
            <h5 class="card-title">Добавить нового владельца</h5>
            <form method="POST" action="{{ route('owners.store') }}" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label class="form-label">ФИО владельца <span class="text-danger">*</span></label>
                    <input type="text" name="full_name" class="form-control" placeholder="Иванов Иван Иванович" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Телефон <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control" placeholder="+7 (999) 000-00-00" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>ФИО владельца</th>
                        <th>Телефон</th>
                        <th>Количество питомцев (withCount)</th>
                        <th>Питомцы в базе</th>
                        <th class="text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($owners as $owner)
                        <tr>
                            <td>{{ $owner->id }}</td>
                            <td><strong>{{ $owner->full_name }}</strong></td>
                            <td>{{ $owner->phone }}</td>
                            <td>
                                <span class="badge {{ $owner->pets_count > 0 ? 'bg-primary' : 'bg-secondary' }} fs-6">
                                    {{ $owner->pets_count }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('pets.index', ['owner_id' => $owner->id]) }}" class="btn btn-sm btn-outline-info">
                                    Посмотреть питомцев
                                </a>
                            </td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('owners.destroy', $owner) }}" class="d-inline"
                                      onsubmit="return confirm('ВНИМАНИЕ! Действует правило ON DELETE CASCADE.\nПри удалении владельца «{{ $owner->full_name }}» будут автоматически и безвозвратно удалены все связанные питомцы ({{ $owner->pets_count }} шт.)!\n\nВы уверены?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Удалить (CASCADE)</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
