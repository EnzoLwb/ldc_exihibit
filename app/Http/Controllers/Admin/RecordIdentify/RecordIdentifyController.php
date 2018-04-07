<?php

namespace App\Http\Controllers\Admin\RecordIdentify;

use App\Dao\ConstDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\AdminUsers;
use App\Models\IdentifyApply;
use App\Models\IdentifyResult;
use Illuminate\Http\Request;
use App\Models\Exhibit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RecordIdentifyController extends BaseAdminController
{
    /**
     * 所有已经鉴定和等待鉴定的列表
     */
    public function record_list(){
        $exhibit_list = IdentifyApply::where('status', ConstDao::EXHIBIT_IDENTIFY_APPLY_AUDITED)->paginate(parent::PERPAGE);
        foreach($exhibit_list as $key=>$item){
            $exhibit_sum_register_id = $item->exhibit_sum_register_id;
            $exhibit_sum_register_ids = explode(',',$exhibit_sum_register_id);
            $new_names = '';
            if(!empty($exhibit_sum_register_ids)){
                $list = Exhibit::whereIn('exhibit_sum_register_id',$exhibit_sum_register_ids)->select('name')->get();
                foreach($list as $item1){
                    $name = $item1->name;
                    $new_names = $new_names.$name.",";
                }
            }
            $exhibit_list[$key]['exhibit_names'] = $new_names;
        }
        $res['list'] = $exhibit_list;
        return view('admin.recordidentify.identify_list', $res);
    }

    /**
     * 查看鉴定结果
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function result_list(){
        $identify_id = \request('identify_id');
        $list = IdentifyResult::where('identify_apply_id', $identify_id)->get();
        foreach ($list as $key=>$item){
            $maker = $item->identify_maker;
            $user_mode = AdminUsers::where('uid', $maker)->first();
            if(empty($user_mode)){
                $list[$key]['username'] = '未知';
            }else{
                $list[$key]['username'] = $user_mode->username;
            }
            $exhibit_sum_register_id = $item->exhibit_sum_register_id;
            $name = Exhibit::where('exhibit_sum_register_id', $exhibit_sum_register_id)->first();
            if(empty($name)){
                $list[$key]['exhibit_name'] = '暂无展品';
            }else{
                $list[$key]['exhibit_name'] = $name->name;
            }

        }
        $res['list'] = $list;
        return view('admin.recordidentify.result_list',$res);
    }

    /**
     * 展示鉴定结果添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function add_result(){
        $identify_apply_id = \request('identify_apply_id');
        $apply_model = IdentifyApply::where('identify_apply_id',$identify_apply_id)->first();
        if(empty($apply_model)){
            return $this->error('抱歉改申请单并未选中藏品');
        }
        $exhibit_ids = $apply_model->exhibit_sum_register_id;
        $exhibit_ids = explode(',', $exhibit_ids);
        $res['exhibit_list'] = Exhibit::whereIn('exhibit_sum_register_id',$exhibit_ids)->get();
        $res['identify_apply_id'] = $identify_apply_id;
        return view('admin.recordidentify.add_result', $res);
    }

    /**
     * 保存鉴定结果
     */
    public function save_result(){
        $identify_apply_id = \request('identify_apply_id');
        $result = new IdentifyResult();
        $result->identify_apply_id = $identify_apply_id;
        $result->exhibit_sum_register_id = \request('exhibit_sum_register_id');
        $result->identify_result = \request('identify_result');
        $result->name = \request('name');
        $result->age = \request('age');
        $result->exhibit_level = \request('exhibit_level');
        $result->type = \request('type');
        $result->quality = \request('quality');
        $result->complete_degree = \request('complete_degree');
        $result->identify_maker = Auth::user()->uid;
        $result->identify_maker = Auth::user()->uid;
        $result->save();
        return $this->success('record_list','保存成功');
    }
}
