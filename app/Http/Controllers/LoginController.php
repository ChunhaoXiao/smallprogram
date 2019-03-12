<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\User;
use Illuminate\Support\Str;
class LoginController extends Controller
{
    public function login(Request $request)
    {
        $code = $request->code;
        $client = new Client;
        $appid = env('SMALL_PROGRAM_APPID');
        $secret = env('SMALL_PROGRAM_SECRET');

         $url = "https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$secret."&js_code=".$code."&grant_type=authorization_code";
        $response = $client->request('GET', $url)->getBody();
        $openid = json_decode($response, true)['openid'];
        $str = Str::random(60);
        User::updateOrCreate(['openid' => $openid], ['api_token' => $str]);
        \Log::info($openid);

        return ['status' => 1, 'sessionId' => $str];
    }
}
