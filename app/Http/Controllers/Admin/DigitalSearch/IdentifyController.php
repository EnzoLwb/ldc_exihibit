<?php

namespace App\Http\Controllers\Admin\DigitalSearch;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Exhibit;
use App\Models\Expert;
use App\Models\IdentifyResult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IdentifyController extends BaseAdminController
{
    /**
     * 鉴定查询
     */
    public function index(){
        $type = \request('type');
        $exhibit_level = \request('exhibit_level');
        $textaure = \request('textaure');
        $complete_degree = \request('complete_degree');
        $profession_skills = \request('profession_skills');
        if(!empty($type)){
            $query = Exhibit::where('type', 'like', '%'.$type.'%');
        }
        if(!empty($exhibit_level)){
            if(isset($query)){
                $query->where('exhibit_level', $exhibit_level);
            }else{
                $query = Exhibit::where('exhibit_level', $exhibit_level);
            }
        }
        if(!empty($textaure)){
            if(isset($query)){
                $query->where('textaure','like','%'.$textaure.'%');
            }else{
                $query = Exhibit::where('textaure', 'like','%'.$textaure.'%');
            }
        }
        if(!empty($complete_degree)){
            if(isset($query)){
                $query->where('complete_degree','like','%'.$complete_degree.'%');
            }else{
                $query = Exhibit::where('complete_degree', 'like','%'.$complete_degree.'%');
            }
        }

        //判断得到展品信息

        if(!empty($profession_skills)){
            if(!isset($query)){
                $res['exhibit_list'] = Exhibit::get();
            }else{
                $res['exhibit_list'] = $query->get();
            }
            $exhibit_ids = array();
            $exhibit_list =$res['exhibit_list'];
            foreach($exhibit_list as $exhibit){
                $exhibit_ids[] = $exhibit->exhibit_sum_register_id;
            }

            //得到专家列表
            $expert_list = Expert::join('admin_users','admin_users.uid','=','expert.admin_user_id')->where('profession_skills', 'like','%'.$profession_skills.'%')->get();
            if(count($expert_list) == 0){
                $res['exhibit_list'] = array();
            }else{
                $expert_ids = array();
                foreach ($expert_list as $expert){
                    $expert_ids[] = $expert->uid;
                }
                $raw_list = IdentifyResult::whereIn('identify_maker', $expert_ids)->get();
                $expert_exhibit_ids =  array();
                foreach ($raw_list as $item){
                    $expert_exhibit_ids[] = $item->exhibit_sum_register_id;
                }
                $intersection = array_intersect($expert_exhibit_ids, $exhibit_ids);
                if(!empty($intersection)){
                    $res['exhibit_list']  = Exhibit::whereIn('exhibit_sum_register_id',$intersection)->paginate(parent::PERPAGE);
                }
            }
        }else{
            if(!isset($query)){
                $res['exhibit_list'] = Exhibit::paginate(parent::PERPAGE);
            }else{
                $res['exhibit_list'] = $query->paginate(parent::PERPAGE);
            }
        }


        return view('admin.digitalsearch.identify.list', $res);
    }
}
