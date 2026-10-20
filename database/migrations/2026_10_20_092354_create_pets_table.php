<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')
                ->constrained('owners')
                ->cascadeOnDelete();
            $table->string('name', 60);
            $table->string('species', 50);
            $table->date('birth_date');
            $table->decimal('weight_kg', 6, 2);
            $table->boolean('is_vaccinated')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
