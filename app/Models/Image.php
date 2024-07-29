<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table = 'image';
    protected $fillable = [
        'sp_id',
        'tenimage',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'sp_id', 'id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'sp_id', 'product_id');
    }
}
