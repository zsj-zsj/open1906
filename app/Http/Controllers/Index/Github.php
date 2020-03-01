<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Model\Github as Git; 
use App\Model\Reg;   
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie; 
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Redis;

class Github extends Controller
{
    public function gituplogin(){
        $code=$_GET['code']; 
        if(empty($code)){
            echo "code不对";die;
        }
        // echo $code;
        $url='https://github.com/login/oauth/access_token';
        $client= new client();
        $response=$client->request('POST',$url,[
            'headers'=>[
                'Accept'=>'application/json'
            ],

            'form_params'=>[
                'client_id'=>env('client_id'),
                'client_secret'=>env('client_secret'),
                'code'=>$code,
            ]
        ]);
        $json=$response->getBody();
        $access_token=json_decode($json,true);
        // dd($a=$access_token['access_token']);
        if(empty($access_token)){
            echo "没有access_token";die;
        }
        $urls='https://api.github.com/user';
        $responses=$client->request('GET',$urls,[
            'headers'=>[
                'Authorization'=>'token '.$access_token['access_token']
            ],
            // 'headers'=>[
            //     'Authorization'=>'OAUTH-TOKEN'
            // ],
            // 'query'=>[
            //     'access_token'=>$access_token['access_token']
            // ],
        ]);
        $json=$responses->getBody();
        $user=json_decode($json,true);     // github返回的 信息
        // print_r($user);

        $git_user=Git::where('github_id','=',$user['id'])->first();
        if($git_user){

        }else{
            $user_email=[
                'l_email'=>$user['email']
            ];
            $reg=Reg::insertGetId($user_email);     //把 gitub email 入到user  返回主键id

            $git_user_info=[
                'l_id'=>$reg,                      //user 主键id  入到gitub  表  
                'github_id'=>$user['id'],
                'location'=>$user['location'],
                'email'=>$user['email']
            ];
            $gitub=Git::create($git_user_info);
        }


        //  登录成功 生成token 返回客户端     
        $token=Str::random(16);
        Cookie::queue('token',$token,60);  //存
        //将token存redis
        $redis_key='uesr:token:'.$token;  //redis的key 
        $user_info=[                     //和取的数据对应
            'l_id'=>$git_user['l_id'],
            'time'=>date('Y-m-d H:i:s')
        ];
        Redis::hMset($redis_key,$user_info);   //哈希
        Redis::expire($redis_key,60*60);      //一小时过期

        header('refresh:0;url=/center');
        echo "登陆成功";
        
    }
}
