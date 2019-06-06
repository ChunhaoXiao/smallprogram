<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Resources\VisitResource;

class VisitController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}

    public function index(Request $request)
    {
    	$user = $request->user();
    	return VisitResource::collection($user->getViewHistory($request->type));
    }
}
