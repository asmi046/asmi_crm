<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\DayWork;
use Illuminate\Http\Request;
use App\Http\Requests\DayWorkRequest;

class DayWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = DayWork::select("client")->groupBy('client')->get();
        return Inertia::render('DayWorks/DayWorks',[
            "works" => DayWork::all(),
            "clients" => $clients
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
    public function store(DayWorkRequest $request)
    {
        $data = $request->validated();

        $pay = DayWork::create( $data );

        return redirect()->route('day_work.index');
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
    public function update(DayWorkRequest $request, DayWork $dayWork)
    {
        $data = $request->validated();
        $dayWork->update( $data );
        return redirect()->route('day_work.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DayWork $dayWork)
    {
        $dayWork->delete();
        return redirect()->route('day_work.index');
    }
}
