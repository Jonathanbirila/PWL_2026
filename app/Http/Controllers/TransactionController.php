<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Tampilkan daftar seluruh transaksi (khusus Admin).
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'details.product', 'supplier'])->latest();

        // Fitur pencarian berdasarkan nomor invoice atau nama pembeli
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $transactions = $query->paginate(10);
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('subtotal');

        return view('transactions.index', compact('transactions', 'totalTransactions', 'totalRevenue'));
    }

    /**
     * Form pembuatan transaksi manual oleh Admin (opsional).
     */
    public function create()
    {
        $products = Product::all();
        $users = User::where('role', 'pembeli')->get();
        $suppliers = Supplier::all();

        return view('transactions.create', compact('products', 'users', 'suppliers'));
    }

    /**
     * Simpan transaksi baru dari Admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'transaction_type' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $transaction = DB::transaction(function () use ($request) {
            $totalSubtotal = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $qty = (int) $item['quantity'];
                $price = (int) ($request->transaction_type === 'pembelian' ? $product->buy_price : $product->sell_price);
                $lineTotal = $price * $qty;

                $totalSubtotal += $lineTotal;
                $itemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $price,
                ];
            }

            $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $trx = Transaction::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => $request->user_id,
                'supplier_id' => $request->supplier_id ?? null,
                'transaction_type' => $request->transaction_type,
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

        return redirect()->route('transactions.show', $transaction->id)
            ->with('success', 'Transaksi berhasil disimpan!');
    }

    /**
     * Tampilkan detail transaksi untuk Admin.
     */
    public function show(string $id)
    {
        $transaction = Transaction::with(['user', 'details.product', 'supplier'])->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Hapus transaksi beserta detailnya.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        DB::transaction(function () use ($transaction) {
            $transaction->details()->delete();
            $transaction->delete();
        });

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}
