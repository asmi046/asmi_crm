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
        Schema::create('setings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->comment('Имя параметра');
            $table->string('type')->comment('Тип параметра');
            $table->string('value')->comment('Значение параметра');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setings');
    }
};
