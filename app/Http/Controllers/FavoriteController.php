<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\FavoriteStoreRequest;
use Auth;
use App\Http\Resources\FavoriteResource;

class FavoriteController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $type = $request->type ?? 'likes';
        $datas = Auth::user()->getFavorites($type);
        return FavoriteResource::collection($datas);
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
