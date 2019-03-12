<?php

namespace App\Http\Middleware;

use Closure;

class CheckBlacklist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $to = $request->to;
        if($user->blacklisted()->where('user_id', $to)->exists())
        {
            return response()->json(['errors' =>['msg' => ['你被TA拉黑了']]], 400);
        }

        return $next($request);
    }
}
