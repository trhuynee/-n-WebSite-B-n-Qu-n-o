<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $table = 'user';
    protected $fillable = [
        'sdt',
        'password',
        'hovaten',
        'email',
        'diachi',
        'phanquyen',
        'avatar',
        'trangthai',
    ];


    public function getAvatarUrl()
    {
        // Assuming 'avatar' is the column name in your users table
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        // Return a default avatar URL if no avatar is set
        return asset('img/default-avatar.png');
    }
}
