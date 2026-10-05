<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('suppliers.index', ['suppliers']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // supplier::create($request)
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('suppliers.show', ['supplier']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('suppliers.update', ['supplier']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // supplier::update($request)
        // ->where()
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Produc::where() -> delete()
    }
}
