<?php

namespace App\Http\Controllers\Admin\ExhibitIdentify;

use App\Dao\ConstDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\AdminUsers;
use App\Models\Expert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ExpertController extends BaseAdminController
{
    /**
     * 鉴定专家列表管理
     */
    public function expert(){
        $title = \request('title');
        if(empty($title)){
            $list = AdminUsers::where('groupid', ConstDao::EXPERT_ROLE_ID)->paginate(parent::PERPAGE);
        }else{
            $list = AdminUsers::where('username','like','%'.$title."%")->where('groupid', ConstDao::EXPERT_ROLE_ID)->paginate(parent::PERPAGE);
        }
        $res = array();
        foreach($list as $key=>$item){
            $admin_user_id = $item['uid'];
            $expert = Expert::where('admin_user_id', $admin_user_id)->first();
            if(empty($expert)) {
                unset($list[$key]);
                continue;
            }
            $list[$key]->sex = $expert->sex;
            $list[$key]->status = $expert->status;
            $list[$key]->expert_id = $expert->expert_id;
            $res[] = $list[$key];
        }
        $res['exhibit_list'] = $res;
        return view('admin.exhibitidentify.expert', $res);
    }

    /**
     * 新增鉴定专家
     */
    public function expert_add(){
        $expert_id = \request('expert_id',-1);
        $expert = Expert::findornew($expert_id);
        $user = AdminUsers::findornew($expert->admin_user_id);
        $expert = $expert->toArray();
        $user = $user->toArray();
        $info = array_merge($expert, $user);
        $res['info'] = $info;
        return view('admin.exhibitidentify.expert_add', $res);
    }

    /**
     * 保存专家信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function expert_save(){
        //保存adminuser信息
        $uid =  \request('uid');
        $username = \request('username');
        $password = \request('password');
        // 处理密码
        $salt = Str::random(6);
        $phone = \request('phone');
        // 添加用户
        DB::transaction(function() use ($password, $salt,$phone,$username, $uid){
            $usersMod = AdminUsers::findorNew($uid);
            $usersMod->username = $username;
            $password = get_password($password, $salt);
            $usersMod->email = '';
            $usersMod->phone = $phone;
            $usersMod->password = $password;
            $usersMod->salt = $salt;
            $usersMod->lastloginip = app('request')->ip();
            $usersMod->save();
            $usersMod->groupid = ConstDao::EXPERT_ROLE_ID;
            //保存扩展信息
            $expert = Expert::where('admin_user_id', $usersMod->uid)->first();
            if(empty($expert)){
                $expert = new Expert();
                $expert->admin_user_id = $usersMod->uid;
            }
            $expert->duties = \request('dutied');
            $expert->sex = \request('sex');
            $expert->status = \request('status');
            $expert->job_title = \request('job_title');
            $expert->depart = \request('depart');
            $expert->identify_result = \request('identify_result');
            $expert->profession_skills = \request('profession_skills');
            $expert->save();
        });
        return $this->success('expert','操作成功');
    }

    public function change_expert_status(){
        $status = \request('status');
        $expert_ids = \request('expert_id');
        if(!empty($expert_ids)){
            Expert::whereIn('expert_id', $expert_ids)->update(array('status'=>$status));
        }
        return $this->success('expert','保存成功');
    }
}
