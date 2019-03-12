<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Models\Message;
Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/g', function(){
	$msg = Message::where('from', 11)->orWhere('to', 11)->get();
	$datas = $msg->groupBy(function($item){
		$key = [$item->from, $item->to];
		sort($key);
		return implode('-', $key);
	});
	dump($datas);
});
*/

Route::get('bm', function(){
	$user = App\User::find(11);
	dump($user->collections()->withCount(['collections' => function($query){
		$query->where('collection_id', 11);
	}])->get());
});