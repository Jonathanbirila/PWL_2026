<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    protected $guarded = ['id'];
    public $timestamps = true;
    protected $fillable = [
        'barcode_number',
        'product_name',
        'supplier_id',
        'buy_price',
        'sell_price'
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
}
