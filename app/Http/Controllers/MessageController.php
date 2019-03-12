<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MessageStoreRequest;
use App\Models\Message;
use Auth;

class MessageController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
		$this->middleware('blacklist')->only('store');
	}

	public function index()
	{
		$user = Auth::user();
		return $user->receivedMessages()->with('user')->paginate(10);
	}

    public function store(MessageStoreRequest $request)
    {
    	$user = Auth::user();
    	$msg = $user->sentMessages()->create($request->only(['content', 'to']));
    	return response()->json($msg, 200);
    }

    public function show($id)
    {
    	$user = Auth::user();
    	return $user->receivedMessages()->with('user')->findOrFail($id);
    }

    public function update(Request $request)
    {
    	$mids = array_filter($request->mids);
    	if(!empty($mids))
    	{
    		Auth::user()->receivedMessages()->whereIn('id', $mids)->update(['viewed' => 1]);
    	}
    	return response()->json('success', 200);
    }

    public function destroy($id)
    {
    	$message = Auth::user()->receivedMessages()->findOrFail($id);
    	if($message->sender_deleted)
    	{
    		$message->delete();
    		return response()->json('success', 200);
    	}
    	$message->update(['receiver_deleted' => 1]);
    	return response()->json('success', 200);
    }
}
