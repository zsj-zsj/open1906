<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Reg;   //注册 登录
use App\Model\Appid;   //注册 登录
use Illuminate\Support\Facades\Hash;

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
                echo 1;
            }else{
                return redirect('login')->with('a','密码不正确');;
            }
        }else{
            return redirect('login')->with('a','手机号或邮箱不存在');;
        }
    }
}
