<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PembeliController extends Controller
{
    /**
     * Tampilkan katalog produk untuk pembeli.
     */
    public function shop()
    {
        $products = Product::with('supplier')->latest()->get();
        return view('pembeli.shop', compact('products'));
    }

    /**
     * Proses transaksi pembelian dari pembeli.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ], [
            'items.required' => 'Pilih minimal satu produk untuk melakukan transaksi.',
            'items.*.quantity.min' => 'Jumlah beli minimal 1.',
        ]);

        $user = Auth::user();

        // Gunakan DB Transaction agar pembuatan transaksi & detail bersifat atomic
        $transaction = DB::transaction(function () use ($request, $user) {
            $totalSubtotal = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                // Lewati item yang quantity-nya 0 atau kosong
                $qty = isset($item['quantity']) ? (int) $item['quantity'] : 0;
                if ($qty <= 0) {
                    continue;
                }

                $product = Product::findOrFail($item['product_id']);
                $price = (int) $product->sell_price;
                $lineTotal = $price * $qty;

                $totalSubtotal += $lineTotal;
                $itemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $price,
                ];
            }

            if (empty($itemsData)) {
                throw new \Exception('Silakan pilih minimal 1 produk dengan kuantitas lebih dari 0.');
            }

            // Generate nomor invoice unik
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $trx = Transaction::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => $user->id,
                'supplier_id' => null,
                'transaction_type' => 'penjualan',
                'subtotal' => $totalSubtotal,
            ]);

            foreach ($itemsData as $data) {
                TransactionDetail::create([
                    'transaction_id' => $trx->id,
                    'product_id' => $data['product_id'],
                    'quantity' => $data['quantity'],
                    'price' => $data['price'],
                ]);
            }

            return $trx;
        });

        return redirect()->route('pembeli.transaction.detail', $transaction->id)
            ->with('success', 'Transaksi berhasil dibuat! No. Invoice: ' . $transaction->invoice_number);
    }

    /**
     * Tampilkan riwayat transaksi pembeli yang sedang login.
     */
    public function history()
    {
        $transactions = Transaction::with(['details.product'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pembeli.history', compact('transactions'));
    }

    /**
     * Tampilkan detail transaksi / nota pembeli.
     */
    public function detail($id)
    {
        $transaction = Transaction::with(['details.product', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pembeli.detail', compact('transaction'));
    }
}

