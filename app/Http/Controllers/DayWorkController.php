<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\DayWork;
use Illuminate\Http\Request;

class DayWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('DayWorks/DayWorks',[
            "works" => DayWork::all()
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
    public function show(DayWork $dayWork)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DayWork $dayWork)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DayWork $dayWork)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DayWork $dayWork)
    {
        //
    }
}
