<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MessageStoreRequest;
use App\Models\Message;
use Auth;
use DB;
use App\Http\Resources\Message as MessageResource;
use App\Http\Resources\MessageList;
use App\Events\MessageRead;

class MessageController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
		$this->middleware('blacklist')->only('store');
	}

	public function index(Request $request)
	{
        $page = $request->page?? 1;
		$uid = Auth::id();
        $datas = Message::group($uid)->slice($page)->get();
        $ids = $datas->pluck('mid');
        $res = Message::range($ids)->get();
        $res->each(function($item) use($uid){
            $item->target_user = $item->from == $uid ? $item->to_user : $item->from_user;
        });
        //return $res;
        return MessageList::collection($res);
	}

    public function store(MessageStoreRequest $request)
    {
    	$user = Auth::user();
    	$msg = $user->sentMessages()->create($request->only(['content', 'to']));
    	return response()->json($msg, 200);
    }

    public function show($id)
    {
        $in = [$id, Auth::id()];
        $datas =  Message::dialog($in)->get();
        event(new MessageRead($datas));
        return MessageResource::collection($datas->reverse());
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
