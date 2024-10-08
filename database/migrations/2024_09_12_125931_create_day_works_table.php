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
        Schema::create('day_works', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 500)->comment('Наименование задачи');
            $table->string('client')->nullable()->comment('Имя клиента');
            $table->string('status')->default('Активна')->comment('Статус задачи');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_works');
    }
};
