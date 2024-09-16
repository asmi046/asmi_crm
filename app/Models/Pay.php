<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
