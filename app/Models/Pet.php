<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    use HasFactory;

    /**
     * Поля, разрешённые для массового заполнения
     */
    protected $fillable = [
        'owner_id',
        'name',
        'description',
        'species',
        'birth_date',
        'weight_kg',
        'is_vaccinated',
    ];

    /**
     * Преобразования типов (casts)
     */
    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'weight_kg' => 'decimal:2',
            'is_vaccinated' => 'boolean',
        ];
    }

    /**
     * Питомец принадлежит владельцу
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }
}
