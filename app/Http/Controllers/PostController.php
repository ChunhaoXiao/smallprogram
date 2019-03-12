<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use App\Http\Resources\User as UserResource;

class PostController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}

	public function index(Request $request, Post $post)
	{
		$user = Auth::user();
		return $post->order()->with('user')->paginate(5);
	}

    public function store(PostStoreRequest $request)
    {
        Auth::user()->savePost($request->all());
        return response()->json('success', 200);
    }

    public function show($id)
    {
    	
    }
}
