<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('transactions.index', ['transactions']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // transaction::create($request)
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('transactions.show', ['transaction']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('transactions.update', ['transaction']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // transaction::update($request)
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
