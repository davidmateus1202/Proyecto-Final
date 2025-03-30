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
        Schema::create('slabs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('abscisa_id')->constrained('abscisas');
            $table->integer('long');
            $table->integer('width');
            $table->string('type_long')->default('cm');
            $table->string('type_width')->default('cm');
            $table->string('latitude');
            $table->string('longitude');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slabs');
    }
};
