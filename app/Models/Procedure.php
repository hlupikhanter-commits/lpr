<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    /**
     * Питомцы, прошедшие эту процедуру (связь многие-ко-многим)
     */
    public function pets(): BelongsToMany
    {
        return $this->belongsToMany(Pet::class)->withTimestamps();
    }
}
