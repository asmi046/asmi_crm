<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pay extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'client',
        'do_time',
        'complet',
        'price',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    protected function doTime(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value)?date("Y-m-d", strtotime($value)):null,
            set: fn ($value) => ($value)?date("Y-m-d", strtotime("+1 day", strtotime($value))):null,
        );
    }
}
