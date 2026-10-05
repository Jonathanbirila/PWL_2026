<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {

        return view('transactionDetails.index', ['transactionDetails']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transactionDetails.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // transactionDetail::create($request)
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('transactionDetails.show', ['transactionDetail']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('transactionDetails.update', ['transactionDetail']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // transactionDetail::update($request)
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
