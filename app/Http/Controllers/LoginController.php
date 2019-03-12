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
        $appid = 'wx549a7828c1343823';
        $secret = 'd73f0b512dbf7d8bee3c3eaf969b78d3';

         $url = "https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$secret."&js_code=".$code."&grant_type=authorization_code";
        $response = $client->request('GET', $url)->getBody();
        $openid = json_decode($response, true)['openid'];
        $str = Str::random(60);
        User::updateOrCreate(['openid' => $openid], ['api_token' => $str]);
        \Log::info($openid);

        return ['status' => 1, 'sessionId' => $str];
    }
}
