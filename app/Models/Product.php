<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "product";
    protected $fillable = [
        'name',
        'image',
        'description',
        'qty',
        'price',
        'seller',
    ];
    use HasFactory;

    public function user()
    {
            return $this->belongsTo(User::class,'seller');
    }
    public function transaction(){
        return $this->hasMany(ProductTransaction::class);
    }

}
