<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Resources\Blacklist;

class BlacklistController extends Controller
{
    public function __construct()
    {
    	return $this->middleware('auth:api');
    }

    public function index()
    {
    	$datas = Auth::user()->getBlacklists();
        return Blacklist::collection($datas);
    }

    public function store(Request $request)
    {
        $user_id = $request->input('user_id');
        return Auth::user()->toggleBlackUser($user_id);
    }

}
