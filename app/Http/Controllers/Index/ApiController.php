<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Appid;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Redis;

class ApiController extends Controller
{
    public function getAccessToken(Request $request){
        // $appid=$_GET['appid'];
        $appid=$request->get('appid');
        $secret=$request->get('secret');

        if(empty($appid) || empty($secret) ){
            echo "缺少参数";die;
        }

        $app=Appid::where('app_id','=',$appid)->first();
        if($appid!=$app['app_id'] || $secret!=$app['secret']){
            echo "参数不正确";die;
        }

        //得到 正确的 appid secret  生成accesstoken
        $str=$appid.$secret.time().rand().Str::random('16');
        $access_token=sha1($str).md5($str);
        $token=substr($access_token,10,30);
        // echo $token;
        //存redis
        $redis_key='h:access_token:'.$token;
        $appinfo=[
            'appid'=>$app['app_id'],
            'time'=>date('Y-m-d H:i:s')
        ];
        Redis::hMset($redis_key,$appinfo);
        Redis::expire($redis_key,7200);

        $respones=[
            'error'=>'0',
            'access_token'=>$access_token,
            'expire'=>7200
        ];
        return $respones;
    }
}
