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
        Schema::create('pays', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 500)->comment('Наименование работы');
            $table->string('client')->comment('Имя клиента');
            $table->date('do_time')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Когда выполнена');
            $table->boolean('complet')->default(false)->comment('Выполнение');
            $table->decimal('price', 8, 0)->default(500)->comment('Цена работы');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pays');
    }
};
