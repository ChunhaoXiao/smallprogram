<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class BlacklistController extends Controller
{
    public function __construct()
    {
    	return $this->middleware('auth:api');
    }

    public function index()
    {
    	$user = Auth::user();
    	return $user->getBlacklists();
    }

    public function store(Request $request)
    {
    	$message = Auth::user()->getOneMessage($request->msg_id);
    	$user->addUserToBlacklist($message->from);
    	return response()->json('success', 200);
    }

    public function destroy($user_id)
    {
    	$user = Auth::user()->removeUserFromBlacklist($user_id);
    	return response()->json('success', 200);
    }
}
