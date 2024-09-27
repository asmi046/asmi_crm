<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayWork extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'client',
        'status',
        'arch_time',
        'check_time',
        'archived',
    ];

    protected static function booted(): void
    {
        static::saving(function (DayWork $work) {
            if ($work->status === "Архив") {
                $work->arch_time = now();
                $work->archived = true;
            }

            if ($work->status === "Завершена") {
                $work->check_time = now();
            }
        });
    }
}
