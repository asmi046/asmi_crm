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
        Schema::table('day_works', function (Blueprint $table) {
            $table->date('arch_time')->nullable()->comment('Дата архивации');
            $table->date('check_time')->nullable()->comment('Дата выполнения');
            $table->boolean('archived')->default(false)->comment('Заархивировано');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('day_works', function (Blueprint $table) {
            //
        });
    }
};
