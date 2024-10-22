<?php

namespace App\Http\Controllers;

use App\Models\Pay;
use Inertia\Inertia;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke() {
        $digest = Pay::selectRaw('client, COUNT(*) as count, SUM(price) as summ')->groupBy('client')->get();
        $price_total = Pay::all()->sum('price');
        return Inertia::render('Index', [
            'worcprice' => $digest,
            'total' => $price_total,
        ]);
    }
}
