@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $title }}</h4>
                    <a href="{{ route('pets.index') }}" class="btn btn-sm btn-light">Назад к списку</a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <strong>Пожалуйста, исправьте следующие ошибки:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ $pet->exists ? route('pets.update', $pet) : route('pets.store') }}">
                        @csrf
                        @if ($pet->exists)
                            @method('PUT')
                        @endif

                        <!-- Поле: Владелец -->
                        <div class="mb-3">
                            <label for="owner_id" class="form-label fw-semibold">Владелец <span class="text-danger">*</span></label>
                            <select name="owner_id" id="owner_id"
                                    class="form-select @error('owner_id') is-invalid @enderror">
                                <option value="">-- Выберите владельца --</option>
                                @foreach ($owners as $owner)
                                    <option value="{{ $owner->id }}"
                                        @selected(old('owner_id', $pet->owner_id) == $owner->id)>
                                        {{ $owner->full_name }} (тел. {{ $owner->phone }})
                                    </option>
                                @endforeach
                            </select>
                            @error('owner_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Поле: Кличка (основное строковое поле) -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Кличка <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name', $pet->name) }}"
                                   placeholder="От 4 до 133 символов"
                                   class="form-control @error('name') is-invalid @enderror">
                            <div class="form-text">Мин. длина: 4 символа (MIN_LEN), макс.: 133 символа (STR_LEN). Кличка уникальна для одного владельца.</div>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Поле: Вид животного -->
                        <div class="mb-3">
                            <label for="species" class="form-label fw-semibold">Вид животного <span class="text-danger">*</span></label>
                            <input type="text" name="species" id="species"
                                   value="{{ old('species', $pet->species) }}"
                                   placeholder="Например: Собака, Кошка, Попугай"
                                   class="form-control @error('species') is-invalid @enderror">
                            @error('species')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Поле: Дата рождения -->
                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label fw-semibold">Дата рождения <span class="text-danger">*</span></label>
                                <input type="date" name="birth_date" id="birth_date"
                                       value="{{ old('birth_date', $pet->birth_date?->format('Y-m-d')) }}"
                                       max="{{ date('Y-m-d') }}"
                                       class="form-control @error('birth_date') is-invalid @enderror">
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Поле: Вес в кг -->
                            <div class="col-md-6 mb-3">
                                <label for="weight_kg" class="form-label fw-semibold">Вес (кг) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0.01" max="300" name="weight_kg" id="weight_kg"
                                       value="{{ old('weight_kg', $pet->weight_kg) }}"
                                       placeholder="Например: 4.50"
                                       class="form-control @error('weight_kg') is-invalid @enderror">
                                @error('weight_kg')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Поле: Описание (добавлено миграцией изменения таблицы) -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Описание / Особые приметы</label>
                            <textarea name="description" id="description" rows="3"
                                      placeholder="Окрас, повадки, номер клейма или чипа..."
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $pet->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Поле: Вакцинация -->
                        <div class="form-check mb-3">
                            <input type="checkbox" name="is_vaccinated" id="is_vaccinated" value="1"
                                   class="form-check-input @error('is_vaccinated') is-invalid @enderror"
                                   @checked(old('is_vaccinated', $pet->is_vaccinated))>
                            <label for="is_vaccinated" class="form-check-label fw-semibold">
                                Питомец привит (наличие актуальных прививок)
                            </label>
                            @error('is_vaccinated')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- ⭐ Связь M:N: Процедуры (чекбоксы) -->
                        <div class="mb-4 p-3 bg-light rounded border">
                            <label class="form-label fw-semibold">Пройденные процедуры (⭐ связь многие-ко-многим):</label>
                            <div class="row">
                                @php
                                    $selectedProcedures = old('procedures', $pet->exists ? $pet->procedures->pluck('id')->toArray() : []);
                                @endphp
                                @foreach ($procedures as $procedure)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="procedures[]"
                                                   value="{{ $procedure->id }}" id="proc_{{ $procedure->id }}"
                                                   @checked(in_array($procedure->id, (array)$selectedProcedures))>
                                            <label class="form-check-label" for="proc_{{ $procedure->id }}">
                                                {{ $procedure->name }}
                                                <span class="text-muted small">({{ number_format($procedure->price, 2, ',', ' ') }} ₽)</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                {{ $pet->exists ? 'Сохранить изменения' : 'Создать питомца' }}
                            </button>
                            <a href="{{ route('pets.index') }}" class="btn btn-secondary">Отмена</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
