<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $fillable = [
        'ma_kh',
        'ngay_lap_hoa_don',
        'ngay_nhan_hang',
        'ttthanhtoan',
        'ttvanchuyen',
        'trangthai',
        'giaohang',
    ];

    public function khachangorder()
    {
        return $this->hasOne(User::class, 'id', 'ma_kh');
    }
    public function orderdetail()
    {
        return $this->hasMany(Order_detail::class, 'ma_hd', 'id');
    }
    public function orderstatus()
    {
        return $this->belongsTo(Order_status::class, 'trangthai', 'id');
    }
}
