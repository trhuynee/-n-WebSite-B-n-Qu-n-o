<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $fillable = [
        'tensanpham',
        'loaisp_id',
        'nh_id',
        'mota',
        'trangthai',
        'soluong'
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'nh_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'loaisp_id', 'id');
    }
    public function image()
    {
        return $this->hasMany(Image::class, 'sp_id');
    }

    public function product_detail()
    {
        return $this->hasMany(Product_detail::class, 'sanpham_id', 'id');
    }

}
