<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MessageStoreRequest;
use App\Models\Message;
use Auth;
use DB;
use App\Http\Resources\Message as MessageResource;
use App\Http\Resources\MessageList;

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
        $datas = Message::mymsg($uid)->select([DB::raw('MAX(id) AS mid'), 'msg_grp'])->groupBy('msg_grp')->orderBy('mid', 'desc')->offset(($page-1) * 10)->limit(10)->get();
        if($datas->isNotEmpty())
        {
            $ids = $datas->pluck('mid');
            $res = Message::whereIn('id', $ids)->with(['from_user', 'to_user'])->get();
            return MessageList::collection($res);
        }
        return [];
        

       // $user->receivedMessages()->with('user')->groupBy('');
		//return $user->receivedMessages()->with('user')->paginate(10);
	}

    public function store(MessageStoreRequest $request)
    {
    	$user = Auth::user();
    	$msg = $user->sentMessages()->create($request->only(['content', 'to']));
    	return response()->json($msg, 200);
    }

    public function show($id)
    {
    	// $user = Auth::user();
    	// return $user->receivedMessages()->with('user')->findOrFail($id);
        $in = [$id, Auth::id()];
        $datas =  Message::whereIn('from', $in)->whereIn('to', $in)->with(['from_user.post', 'to_user.post'])->latest()->limit(10)->get();
        return MessageResource::collection($datas->reverse());
        //return $datas;
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
