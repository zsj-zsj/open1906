<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reg extends Model
{
    protected $table="reg";
    protected $primaryKey="l_id";
    protected $guarded=[]; //黑名单
}
