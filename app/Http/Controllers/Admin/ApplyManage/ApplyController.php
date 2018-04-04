<?php

namespace App\Http\Controllers\Admin\ApplyManage;

use App\Dao\ConstDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\CollectApply;
use App\Models\Exhibit;
use App\Models\IdentifyApply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApplyController extends BaseAdminController
{
    public function export_collect_apply(){
        $type = \request('apply_type', ConstDao::APPLY_TYPE_COLLECT);
        $res['type'] = $type;
        if($type == ConstDao::APPLY_TYPE_COLLECT){
            $res['exhibit_list'] = CollectApply::whereIn('status', array_keys(ConstDao::$collect_apply_desc))->paginate(parent::PERPAGE);
            return view('admin.applymanage.collect_apply', $res);
        }elseif($type == ConstDao::APPLY_TYPE_IDENTIFY){
            $exhibit_list = IdentifyApply::whereIn('status', array_keys(ConstDao::$identify_desc))->paginate(parent::PERPAGE);
            //添加展品信息
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
            $res['exhibit_list'] = $exhibit_list;
            return view('admin.applymanage.identify_apply', $res);
        }
    }

    /**
     * 批量审核通过
     */
    public function collect_apply_pass(){
        $collect_apply_ids = \request('collect_apply_ids');
        //检测是否存在已经审核过的数据
        $count = CollectApply::where('status', '!=',ConstDao::EXHIBIT_COLLECT_APPLY_WAITING_AUDIT)->whereIn('collect_apply_id', $collect_apply_ids)->count();
        if($count>0){
            return response_json(0, array(),'抱歉，所选项存在已审核过的数据');
        }else{
            CollectApply::where('status',ConstDao::EXHIBIT_COLLECT_APPLY_WAITING_AUDIT)->whereIn('collect_apply_id', $collect_apply_ids)->update(array('status'=>
            ConstDao::EXHIBIT_COLLECT_APPLY_AUDITED));
            return response_json(1, array(),'操作完成');
        }
    }

    /**
     * 征集申请拒绝
     * @return \Illuminate\Http\JsonResponse
     */
    public function collect_apply_refuse(){
        $collect_apply_ids = \request('collect_apply_ids');
        //检测是否存在已经审核过的数据
        $count = CollectApply::where('status', '!=',ConstDao::EXHIBIT_COLLECT_APPLY_WAITING_AUDIT)->whereIn('collect_apply_id', $collect_apply_ids)->count();
        if($count>0){
            return response_json(0, array(),'抱歉，所选项存在已审核过的数据');
        }else{
            CollectApply::where('status',ConstDao::EXHIBIT_COLLECT_APPLY_WAITING_AUDIT)->whereIn('collect_apply_id', $collect_apply_ids)->update(array('status'=>
                ConstDao::EXHIBIT_COLLECT_APPLY_REFUSED));
            return response_json(1, array(),'操作完成');
        }
    }

    /**
     * 鉴定申请 批量通过
     */
    public function identify_apply_pass(){
        $identify_apply_ids = \request('identify_apply_ids');
         //检测是否存在已经审核过的数据
        $count = IdentifyApply::where('status', '!=',ConstDao::EXHIBIT_IDENTIFY_APPLY_WAITING_AUDIT)->whereIn('identify_apply_id', $identify_apply_ids)->count();
        if($count>0){
            return response_json(0, array(),'抱歉，所选项存在已审核过的数据');
        }else{
            IdentifyApply::where('status',ConstDao::EXHIBIT_COLLECT_APPLY_WAITING_AUDIT)->whereIn('identify_apply_id', $identify_apply_ids)->update(array('status'=>
                ConstDao::EXHIBIT_IDENTIFY_APPLY_AUDITED));
            return response_json(1, array(),'操作完成');
        }
    }

    public function identify_apply_refuse(){
        $identify_apply_ids = \request('identify_apply_ids');
        //检测是否存在已经审核过的数据
        $count = IdentifyApply::where('status', '!=',ConstDao::EXHIBIT_IDENTIFY_APPLY_WAITING_AUDIT)->whereIn('identify_apply_id', $identify_apply_ids)->count();
        if($count>0){
            return response_json(0, array(),'抱歉，所选项存在已审核过的数据');
        }else{
            IdentifyApply::where('status',ConstDao::EXHIBIT_COLLECT_APPLY_WAITING_AUDIT)->whereIn('identify_apply_id', $identify_apply_ids)->update(array('status'=>
                ConstDao::EXHIBIT_IDENTIFY_APPLY_REFUSED));
            return response_json(1, array(),'操作完成');
        }
    }
}
