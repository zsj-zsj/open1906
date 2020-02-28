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
    public function doreg(Request $request){
        $request->validate([
            //验证
            'l_name'=>'required|alpha_dash|between:3,7|unique:reg',
            'l_company'=>'required',
            'l_legal'=>'required',
            'l_address'=>'required',
            'l_logo'=>'required|image',
            'l_phone'=>'required|unique:reg',
            'l_pass'=>'required|between:3,7|alpha_dash',
            'l_email'=>'required|email|unique:reg',
            'l_pass22'=>'same:l_pass'
        ],[
            //错误提示
            'l_name.required'=>'用户名不能为空',
            'l_name.alpha_dash'=>'用户名中文字母和数字，以及破折号和下划线',
            'l_name.between'=>'用户名长度3-7位',
            'l_name.unique'=>'用户名已存在',
            'l_company.required'=>'请输入公司名',
            'l_legal.required'=>'请输入法人',
            'l_address.required'=>'请输入公司地址',
            'l_logo.required'=>'请上传营业执照',
            'l_logo.image'=>'请上传图片',
            'l_phone.required'=>'请输入手机号',
            'l_phone.unique'=>'手机号已注册',
            'l_email.required'=>'请输入邮箱',
            'l_email.email'=>'邮箱格式不对',
            'l_email.unique'=>'邮箱已注册',
            'l_pass.required'=>'请输入密码',
            'l_pass.between'=>'密码长度3-7字母和数字,以及破折号和下划线',
            'l_pass22.same'=>'密码不一致',
        ]);
        $post=request()->input();
        unset($post['l_pass22']);
        $reg='/^1[345789]\d{9}$/';
        if(!preg_match($reg,$post['l_phone'])){     
            return redirect('reg')->with('a','手机号格式不对');
        }

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
                return redirect('login')->with('a','密码不正确');
            }
        }else{
            return redirect('login')->with('a','手机号或邮箱不存在');
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
