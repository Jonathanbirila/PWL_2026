<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gets = Product::with('supplier')->latest()->get();
        return view('product.index', compact('gets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supp = Supplier::all();
        return view('product.create', compact('supp'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'barcode_number' => 'required|unique:products,barcode_number',
            'product_name' => 'required',
            'buy_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        Product::create($request->all());

        return redirect()->route('product.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $supp = Supplier::all();
        return view('product.edit', compact('product', 'supp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'barcode_number' => 'required|unique:products,barcode_number,' . $product->id,
            'product_name' => 'required',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        $product->update($request->all());

        return redirect()->route('product.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('product.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
