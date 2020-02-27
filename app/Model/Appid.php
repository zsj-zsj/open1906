<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appid extends Model
{
    protected $table="p_appid";
    protected $guarded=[]; //黑名单

    //appid
    public static function appid($name){
        $md5=md5($name.time().mt_rand(11111,99999));
        $str='id'.substr($md5,0,14);
        return $str;
    } 

    //secret
    public static function secret(){
        return Str::random(32);
    }
}
