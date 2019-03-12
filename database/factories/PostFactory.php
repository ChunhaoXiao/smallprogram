<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Post::class, function (Faker $faker) {

    return [
        'content' => '这是我的爱情宣言，这是我的爱情宣言，这是我的爱情宣言，这是我的爱情宣言，这是我的爱情宣言，这是我的爱情宣言，这是我的爱情宣言。',
        'gender' => array_rand(array_flip(['男', '女'])),
        'contact' => '88901236',

    ];
});
