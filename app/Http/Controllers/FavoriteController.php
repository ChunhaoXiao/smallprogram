<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\FavoriteStoreRequest;
use Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth:api');
    }

    public function index()
    {
    	$user = Auth::user();
    	$favorites = $user->receivedFavorites()->with('user')->paginate(10);
    	return $favorites;
    }

    public function store(FavoriteStoreRequest $request)
    {
    	$user = Auth::user();
    	$status = $user->updateFavorite($request->only(['to_user']));
    	return response()->json(['status' => $status], 200);
    }

    public function update(Request $request)
    {
    	$fids = array_filter($request->fid);
    	if(!empty($fids))
    	{
    		Auth::user()->receivedFavorites()->whereIn('id', $fids)->update(['viewed' => 1]);
    	}
    	return response()->json('success', 200);
    }
}
