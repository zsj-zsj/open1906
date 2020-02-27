<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Reg;   //注册 登录
use App\Model\Appid;   
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie; 
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Redis;

class Login extends Controller
{
    //文件上传
    public function upload($file){
        if(request()->file($file)->isValid()){
            $img=request()->file($file);
            $imgimg=$img->store('images');
            return $imgimg;
        }
        exit('文件未上传或上传出错');
    }

    //展示注册
    public function reg(){
        return view('index/reg');
    }

    //执行注册
    public function doreg(){
        $post=request()->input();

        if(request()->hasFile('l_logo')){    
            $post['l_logo']=$this->upload('l_logo');
        }
        //注册入库
        $post['l_pass']=bcrypt($post['l_pass']);

        $res=Reg::create($post);
        if($res){

            $appid=Appid::appid($post['l_name']);
            // echo $appid;echo "<br>";
            $secret=Appid::secret();
            // echo $secret;echo "<br>";
            //appid secret  入库
            $data=[
                'l_id'=>$res['l_id'],
                'app_id'=>$appid,
                'secret'=>$secret,
            ];
            Appid::create($data);

            return redirect('login');
        }else{
            return redirect('reg'); 
        }
    }

    public function login(){
        return view('index/login');
    }

    public function dologin(){
        $post=request()->input();
        // dd($post);
        $phone=$post['l_phone'];

        $res=Reg::where('l_phone','=',$phone)->orwhere('l_email','=',$phone)->orwhere('l_name','=',$phone)->first();
        // dd($res);
        if($res){
            if(Hash::check($post['l_pass'],$res['l_pass'])){
                //  登录成功 生成token 返回客户端     
                $token=Str::random(16);
                Cookie::queue('token',$token,60);  //存
                //将token存redis
                $redis_key='uesr:token:'.$token;  //redis的key 
                $user_info=[
                    'l_id'=>$res['l_id'],
                    'l_name'=>$res['l_name'],
                    'time'=>date('Y-m-d H:i:s')
                ];
                Redis::hMset($redis_key,$user_info);   //哈希
                Redis::expire($redis_key,60*60);      //一小时过期

                header('refresh:2;url=/center');
                echo "登陆成功";
                
            }else{
                return redirect('login')->with('a','密码不正确');;
            }
        }else{
            return redirect('login')->with('a','手机号或邮箱不存在');;
        }
    }

    public function center(){
        $token=Cookie::get('token'); //取
        if(empty($token)){
            header('refresh:1;url=/login');
            echo "请先登录";die;
        }
        $redis_key='uesr:token:'.$token;  //redis的key 
        $user_info=Redis::hgetAll($redis_key);  //取  user
    
        $id=$user_info['l_id'];
        $app=Appid::where('id','=',$id)->first()->toArray();  //app

        echo "欢迎来到：".$user_info['l_name']."的用户中心";echo "<br>";
        echo "APPID：".$app['app_id'];echo "<br>";
        echo "SECRET：".$app['secret'];echo "<br>";

    }
}
