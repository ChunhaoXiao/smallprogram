<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Resources\User;

class VisitController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}

    public function index(Request $request)
    {
    	$user = $request->user();
        $datas = $user->getViewHistory($request->type);
        $target = $request->type == 'viewers' ? 'viewed' : 'viewers';
        return User::collection($datas->pluck($target));
    }
}
