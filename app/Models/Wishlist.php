<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = 'wishlist';

    protected $fillable = [
        'user_id',
        'product_id',
        'product_detail_id',
        'color_id',
        'size_id',
        'soluong',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function productDetail()
    {
        return $this->belongsTo(Product_detail::class, 'product_detail_id', 'id');
    }
}
