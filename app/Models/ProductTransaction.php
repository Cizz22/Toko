<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model
{
    use HasFactory;
    protected $table = 'product_transactions';
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function transaction(){
        return $this->belongsTo(Transaction::class, 'invoice_number', 'invoice_number');
    }

}
