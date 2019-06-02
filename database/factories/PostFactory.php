<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Post::class, function (Faker $faker) {

    return [
        'content' => '这是我的爱情宣言，这是我的爱情宣言，这是我的爱情宣言，这是我的爱情宣言，这是我的爱情宣言，这是我的爱情宣言，这是我的爱情宣言。',
        'gender' => array_rand(array_flip(['男', '女'])),
        'contact' => '88901236',
        'nickname' => $faker->name,
        'bod' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'location' => ['辽宁省', '大连市', '中山区'],
        'marriage' => '未婚',
        'hobby' => '运动,读书',
    ];
});
