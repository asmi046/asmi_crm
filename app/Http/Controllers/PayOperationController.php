<?php

namespace App\Http\Controllers;

use App\Models\Pay;
use Illuminate\Http\Request;

class PayOperationController extends Controller
{
    public function pay_msaa_check(Request $request) {
        $ids = $request->input('ids');
        $res = Pay::whereIn('id', $ids)->update(['complet' => true]);

        return redirect()->back()->with('count', $res);

        // return $res;
    }
}
