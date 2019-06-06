<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Resources\User;

class BlacklistController extends Controller
{
    public function __construct()
    {
    	return $this->middleware('auth:api');
    }

    public function index()
    {
    	$datas = Auth::user()->getBlacklists();
        return User::collection($datas->pluck('user'));
    }

    public function store(Request $request)
    {
        $user_id = $request->input('user_id');
        return Auth::user()->toggleBlackUser($user_id);
    }

}
