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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->nullable()->comment('Наименование');
            $table->string('site')->nullable()->comment('Адрес сайта');
            $table->string('phone')->nullable()->comment('Телефон контактного лица');
            $table->text('description')->nullable()->comment('Основные данные');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
