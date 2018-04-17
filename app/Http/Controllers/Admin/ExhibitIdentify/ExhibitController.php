<?php

namespace App\Http\Controllers\Admin\ExhibitIdentify;

use App\Dao\ConstDao;
use App\Models\IdentifyApply;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Exhibit;
use Illuminate\Support\Facades\DB;

/**
 * 鉴定相关功能
 * Class ExhibitController
 * @package App\Http\Controllers\Admin\ExhibitIdentify
 */
class ExhibitController extends BaseAdminController
{
    /**
     * 申请列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function apply(){
        $exhibit_list = IdentifyApply::where('status', ConstDao::EXHIBIT_IDENTIFY_APPLY_DRAFT)->paginate(parent::PERPAGE);
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
        return view('admin.exhibitidentify.apply', $res);
    }

    /**
     *为鉴定申请提供总账列表
     */
    public function get_exhibit_list(){
        $res['exhibit_list'] = Exhibit::paginate(parent::PERPAGE);
        return view('admin.exhibitidentify.exhibit_list', $res);
    }

    /**
     * 鉴定申请保存，信息编辑
     */
    public function apply_save(Request $request){
        $identify_apply_id = \request('identify_apply_id');
        $info = IdentifyApply::findorNew($identify_apply_id);
        $data = $request->all();
        foreach($data as $key=>$v){
            if($key == "_token") continue;
            $info->$key = $v;
        }
        $info->status = ConstDao::EXHIBIT_IDENTIFY_APPLY_DRAFT;
        $info->save();
        return $this->success('apply','操作完成');
    }

    /**
     * 申请提交审核
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function apply_submit(){
        $ids = \request('identify_apply_id');
        //判断申请是否都是草稿状态
        $count = IdentifyApply::where('status','!=', ConstDao::EXHIBIT_IDENTIFY_APPLY_DRAFT)->whereIn('identify_apply_id', $ids)->count();
        if($count>0){
            return $this->error('抱歉所选申请中包含已经提交过的申请');
        }
        IdentifyApply::whereIn('identify_apply_id', $ids)->update(array('status'=>ConstDao::EXHIBIT_IDENTIFY_APPLY_WAITING_AUDIT));
        return $this->success('apply','操作完成');
    }



    /**
     * 申请删除
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function apply_del(){
        $identify_apply_id = \request('identify_apply_id');
        IdentifyApply::where('identify_apply_id', $identify_apply_id)->delete();
        return $this->success('apply','操作成功');
    }


    public function add_identify_result(){
        return view('admin.exhibitidentify.add_identify_result');
    }

    /**
     * 展示添加按钮
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        $identify_apply_id = \request('identify_apply_id');
        $res['info'] = IdentifyApply::findorNew($identify_apply_id);
        return view('admin.exhibitidentify.add', $res);
    }

    /**
     * 鉴定管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage(){
        $exhibit_list = IdentifyApply::whereIn('status', array(ConstDao::EXHIBIT_IDENTIFY_APPLY_REFUSED, ConstDao::EXHIBIT_COLLECT_APPLY_AUDITED))->paginate(parent::PERPAGE);
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
        return view('admin.exhibitidentify.manage', $res);
    }

    /**
     * 辅助文物列表
     */
    public function get_sub_exhibit_list(){
        $res['exhibit_list'] = Subsidiary::select(DB::Raw('subsidiary_id as exhibit_sum_register_id'), 'name')->paginate(parent::PERPAGE);
        return view('admin.exhibitidentify.exhibit_list', $res);
    }
}
