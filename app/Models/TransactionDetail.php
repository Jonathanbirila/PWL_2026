<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = "transaction_details";
    protected $guarded = ['id'];
    public $timestamps = true;
    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price'
    ];

    public function Product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function Transaction() {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}
