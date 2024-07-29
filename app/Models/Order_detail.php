<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    use HasFactory;
    protected $table = 'order_detail';
    protected $fillable = [
        'ma_hd',
        'sp_id',
        'chitietietsp_id',
        'soluong',
        'giaohang',
        'thanhtien',
        'diachi',
        'size',
        'color'
    ];
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'sp_id');
    }
    public function productDetail()
    {
        return $this->belongsTo(Product_detail::class, 'sp_id', 'sanpham_id');
    }
    public function order()
    {
        return $this->hasMany(Order::class, 'id', 'ma_hd');
    }
    public function orderdetail()
    {
        return $this->belongsTo(Order_detail::class, 'chitietsp_id', 'id');
    }
     public function sizeDetail()
    {
        return $this->belongsTo(Size::class, 'size', 'id');
    }
      public function colorDetail()
    {
        return $this->belongsTo(Color::class, 'color', 'id');
    }
}
