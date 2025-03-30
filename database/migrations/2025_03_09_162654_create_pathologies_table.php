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
        Schema::create('pathologies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slab_id')->constrained('slabs');
            $table->string('name');
            $table->string('url_image');
            $table->integer('long_damage');
            $table->string('type_long_damage')->default('cm');
            $table->integer('width_damage');
            $table->string('type_width_damage')->default('cm');
            $table->integer('repair_long');
            $table->string('type_repair_long')->default('cm');
            $table->integer('repair_width');
            $table->string('type_repair_width')->default('cm');
            $table->string('type_damage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pathologies');
    }
};
