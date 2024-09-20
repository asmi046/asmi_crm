<?php

namespace App\Http\Controllers;

use App\Models\Pay;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\PayRequest;

class PayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pays = Pay::all()->map(function ($item) {
            $item->price = (int)$item->price + 1;
            return $item;
        });

        return Inertia::render('Pay/Pay',[
            "pays" => Pay::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pay $pay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pay $pay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PayRequest $request, Pay $pay)
    {
        $data = $request->validated();

        $pay->update( $data );

        return redirect()->route('pay.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pay $pay)
    {
        //
    }
}
