<?php

namespace App\Dao;

use App\Models\Expert;
use Illuminate\Database\Eloquent\Model;

class ExpertDao extends Expert
{
    /**
     * 获得专家列表
     */
    public static function  get_expert_list(){
        return self::join('admin_users','admin_users.uid', '=' ,'expert.admin_user_id')->select('username','uid')->get();
    }
}
