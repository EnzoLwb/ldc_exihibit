<?php

namespace App\Http\Controllers\Admin\RecordIdentify;

use App\Dao\ConstDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\IdentifyApply;
use Illuminate\Http\Request;
use App\Models\Exhibit;
use App\Http\Controllers\Controller;

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
        $res['list'] = array();
        return view('admin.recordidentify.result_list',$res);
    }


    public function add_result(){
        $identify_apply_id = \request('identify_apply_id');
        $apply_model = IdentifyApply::where('identify_apply_id',$identify_apply_id)->first();
        if(empty($apply_model)){
            return $this->error('抱歉改申请单并未选中藏品');
        }
        $exhibit_ids = $apply_model->exhibit_sum_register_id;
        $exhibit_ids = explode(',', $exhibit_ids);
        $res['exhibit_list'] = Exhibit::whereIn('exhibit_sum_register_id',$exhibit_ids)->get();
        return view('admin.recordidentify.add_result', $res);
    }
}
