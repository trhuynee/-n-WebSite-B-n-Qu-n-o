<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        Category::where('name','Laptop')->first()->products()->createMany([

            [
                'name'=> 'Xiaomi Redmi Note 7 (64GB)',
                'price'=> 4900000,
                'image'=> 'img/xiaomi-redmi-note-7-hpbd.jpg',
                'desc'=> 'Tặng sạc dự phòng 5000 mAh hoặc tặng phiếu mua hàng 10% giá trị sản phẩm đang xem và 1 K.mãi khác'
            ],
            [
                'name'=> 'Samsung Galaxy A50 (64GB)',
                'price'=> 6900000,
                'image'=> 'img/samsung-galaxy-a50-hpbd.jpg',
                'desc'=> 'Tặng phiếu mua hàng 10% giá trị sản phẩm đang xem và 1 K.mãi khác'
            ],
            [
                'name'=> 'Iphone 6s Plus (32GB)',
                'price'=> 9900000,
                'image'=> 'img/iphone-6s-plus-32gb-hpbd.jpg',
                'desc'=> 'Tặng sạc dự phòng Polymer 5000 mAh và 3 K.mãi khác'
            ],
            [
                'name' => 'Samsung Galaxy A10',
                'price' => 3090000,
                'image' => 'img/samsung-galaxy-a10-hpbd.jpg',
                'desc' => 'Tặng phiếu mua hàng 10% giá trị sản phẩm đang xem và 1 K.mãi khác'
            ],
            [
                'name' => 'OPPO A5s',
                'price' => 3990000,
                'image' => 'img/oppo-a5s-hpbd.jpg',
                'desc' => 'Tặng sạc dự phòng 5000 mAh hoặc tặng phiếu mua hàng 10% giá trị sản phẩm đang xem và 1 K.mãi khác'
            ],
            [
                'name' => 'Vivo Y15',
                'price' => 4990000,
                'image' => 'img/vivo-y15-hpbd.jpg',
                'desc' => 'Tặng sạc dự phòng 5000 mAh hoặc tặng phiếu mua hàng 10% giá trị sản phẩm đang xem và 1 K.mãi khác'
            ],
            [
                'name' => 'iPhone Xs Max(64GB)',
                'price' => 29990000,
                'image' => 'img/iphone-xs-max-gray-400x400.jpg',
                'desc' => 'Tặng sạc dự phòng Polymer 5000 mAh và 3 K.mãi khác'
            ],
            [
                'name' => 'iPhone X (256GB)',
                'price' => 29990000,
                'image' => 'img/iphone-x-256gb-a1-400x400.jp',
                'desc' => 'Tặng sạc dự phòng Polymer 5000 mAh và 3 K.mãi khác'
            ]

        ]);
    }
}