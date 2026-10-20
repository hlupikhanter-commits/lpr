<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
    ];

    /**
     * Питомец принадлежит владельцу (один владелец — много питомцев)
     */
    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class);
    }
}
