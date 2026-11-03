<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = "suppliers";
    protected $guarded = ['id'];
    public $timestamps = true;
    protected $fillable = [
        'supplier_name',
        'phone',
        'email'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'supplier_id', 'id');
    }
}
