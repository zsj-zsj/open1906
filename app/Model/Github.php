<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Github extends Model
{
    protected $table="p_user_github";
    protected $guarded=[]; //黑名单
}
