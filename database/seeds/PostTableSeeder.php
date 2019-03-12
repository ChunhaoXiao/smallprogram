<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(\App\User::class,10)->create();
        $users->each(function($user){
        	$user->post()->save(factory(\App\Models\Post::class)->make());
        });
    }
}
