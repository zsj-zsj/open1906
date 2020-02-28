<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
class AccessToken
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
        $token=$request->get('access_token');
        if(empty($token)){
            echo "授权失败 缺少access_token参数";die;
        }
        $tokens=substr($token,10,30);
        $redis_key='h:access_token:'.$tokens;
        $data=Redis::hGetAll($redis_key);

        if(empty($data)){
            echo "授权失败 access_token 无效";die;
        }

        return $next($request);
    }
}
