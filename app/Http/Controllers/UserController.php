<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use App\Events\MemberViewed;

class UserController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}

    public function index(Request $request)
    {
    	$datas = User::hasPost()->gender($request->gender)->unblacklisted(Auth::id())->order()->paginate(5);
        return new UserCollection($datas);
    }

    public function show($id)
    {
    	$user_id = Auth::id();
    	$user = User::unblacklisted($user_id)->favorite($user_id)->collect($user_id)->with('post')->find($id);
        event(new MemberViewed($user));
    	return new UserResource($user);
    }

    public function update(Request $request, $id = '')
    {
    	$request->validate([
    		'name' => 'nullable|min:2|max:30',
    	]);
    	$data = array_filter($request->all(), 'strlen');
    	if(!empty($data))
    	{
    		$user = Auth::user()->update($data);
    	}
    	
    	return $user;
    }
}
