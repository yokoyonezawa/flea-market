<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //
    public function run()
    {
        // 出品者の作成
        $user1 = User::create([
            'name' => '出品者1',
            'email' => 'yoko@yahoo.co.jp',
            'password' => bcrypt('11111111'),
        ]);

        $user2 = User::create([
            'name' => '出品者2',
            'email' => 'yuhi@yahoo.co.jp',
            'password' => bcrypt('11111111'),
        ]);

        $user3 = User::create([
            'name' => '出品していないユーザー',
            'email' => 'toru@yahoo.co.jp',
            'password' => bcrypt('11111111'),
        ]);

        // 出品者1が商品1〜6を出品
        $products1 = [
            [
                'name' => '腕時計',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
                'detail' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => 15000,
                'category_id' => 1,
                'condition_id' => 1,
            ],
            [
                'name' => 'HDD',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                'detail' => '高速で信頼性の高いハードディスク',
                'price' => 5000,
                'category_id' => 2,
                'condition_id' => 2,
            ],
            [
                'name' => '玉ねぎ3束',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                'detail' => '新鮮な玉ねぎ3束のセット',
                'price' => 300,
                'category_id' => 10,
                'condition_id' => 3,
            ],
            [
                'name' => '革靴',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                'detail' => 'クラシックなデザインの革靴',
                'price' => 4000,
                'category_id' => 1,
                'condition_id' => 4,
            ],
            [
                'name' => 'ノートPC',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                'detail' => '高性能なノートパソコン',
                'price' => 45000,
                'category_id' => 2,
                'condition_id' => 1,
            ],
        ];

        foreach ($products1 as $data) {
            $user1->products()->create($data); // user_id を自動で埋めてくれる
        }

        // 出品者2が商品7〜10を出品
        $products2 = [
            [
                'name' => 'マイク',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                'detail' => '高音質のレコーディング用マイク',
                'price' => 8000,
                'category_id' => 2,
                'condition_id' => 2,
            ],

            [
                'name' => 'ショルダーバッグ',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                'detail' => 'おしゃれなショルダーバッグ',
                'price' => 3500,
                'category_id' => 4,
                'condition_id' => 3,
            ],
            [
                'name' => 'タンブラー',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                'detail' => '使いやすいタンブラー',
                'price' => 500,
                'category_id' => 10,
                'condition_id' => 4,
            ],
            [
                'name' => 'コーヒーミル',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                'detail' => '手動のコーヒーミル',
                'price' => 4000,
                'category_id' => 10,
                'condition_id' => 1,
            ],
            [
                'name' => 'メイクセット',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                'detail' => '便利なメイクアップセット',
                'price' => 2500,
                'category_id' => 6,
                'condition_id' => 2,
            ],
        ];

        foreach ($products2 as $data) {
            $user2->products()->create($data);
        }


    }
}


