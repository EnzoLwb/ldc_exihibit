<?php

namespace App\Http\Controllers\Admin\ExhibitManage;

use App\Dao\ConstDao;
use App\Models\Exhibit;
use App\Models\ExhibitUse;
use App\Models\ExhibitUsedApply;
use App\Models\ExhibitUseItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\DB;

class InstorageManageController extends BaseAdminController
{
    /**
     * 入库管理列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $list = Exhibit::all();
        $res['exhibit_list'] = $list;
        return view('admin.exhibitmanage.instorage_list', $res);
    }

    /**
     * 增加入库记录（实际上试修改展品信息）
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_instorageroom(){
        $exhibit_sum_register_id = \request('exhibit_sum_register_id');
        $exhibit = Exhibit::join('collect_recipe', 'exhibit.collect_recipe_id','=','collect_recipe.collect_recipe_id','left')
            ->where('exhibit_sum_register_id', $exhibit_sum_register_id)->select('exhibit_sum_register_id',DB::Raw('ldc_exhibit.backup as backup'),
                'name','exhibit_sum_register_num',DB::Raw('ldc_exhibit.collect_recipe_num as collect_recipe_num'),'num','age','exhibit_level','size','quality','complete_degree','room_number',
                'in_museum_time','src','recipe_num')->first();
        if(empty($exhibit)){
            return $this->error('抱歉参数有误');
        }
        $res['info'] = $exhibit;
        return view('admin.exhibitmanage.add_instorage', $res);
    }

    /**
     * 入库信息保存
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function instorageroom_save(Request $request){
        $exhibit_sum_register_id = \request('exhibit_sum_register_id');
        $exhibit = Exhibit::where('exhibit_sum_register_id', $exhibit_sum_register_id)->first();
        if(empty($exhibit)){
            return $this->error('参数有误');
        }
        $except = array('_token',"recipe_num");
        $all = $request->all();
        foreach($all as $k=>$v){
            if(!in_array($k,$except)){
                $exhibit->$k = $v;
            }
        }
        $exhibit->save();
        return $this->success('instorageroom','保存成功');
    }

    /**
     *  出库申请
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function oustorageapply(){

        $executer = \request('executer');
        if(empty($executer)){
            $list = ExhibitUsedApply::get();
        }
        else{
            $list = ExhibitUsedApply::where('executer','like','%'.$executer."%")->get();
        }
        foreach($list as $key=>$item){
            $exhibit_ids = $item->exhibit_list;
            $exhibit_ids = explode(",", $exhibit_ids);
            $names = '';
            if(!empty($exhibit_ids)){
                $exhibits = Exhibit::whereIn('exhibit_sum_register_id', $exhibit_ids)->get();
            }
            foreach($exhibits as $exhibit){
                $names .= $exhibit->name.",";
            }
            $list[$key]->exhibit_names = $names;
        }
        $res['exhibit_list'] = $list;
        return view('admin.exhibitmanage.oustorageapply_list', $res);
    }

    /**
     * 增加出库申请
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_oustorageapply(){
        $exhibit_used_apply_id = \request('exhibit_used_apply_id');
        $info = ExhibitUsedApply::where( 'exhibit_used_apply_id', $exhibit_used_apply_id)->first();
        $res['info'] = $info;
        return view('admin.exhibitmanage.add_oustorageapply', $res);
    }


    /**
     * 保存出库申请的相关信息
     */
    public function oustorageapply_save(){
        $exhibit_used_apply_id = \request('exhibit_used_apply_id');
        $exhibit_used_apply = ExhibitUsedApply::findOrNew($exhibit_used_apply_id);
        $exhibit_used_apply->apply_depart_name = \request('apply_depart_name');
        $exhibit_used_apply->executer = \request('executer');
        $exhibit_used_apply->connectioner = \request('connectioner');
        $exhibit_used_apply->phone = \request('phone');
        $exhibit_used_apply->outer_time = \request('outer_time');
        $exhibit_used_apply->outer_destination = \request('outer_destination');
        $exhibit_sum_register_ids = \request('exhibit_sum_register_id');
        if(empty($exhibit_sum_register_ids)){
            return $this->error('请选择展品');
        }
        $exhibit_used_apply->type = ConstDao::EXHIBIT_USED_OUTER;
        $exhibit_used_apply->status = ConstDao::EXHIBIT_USED_APPLY_STATUS_DRAFT;
        $exhibit_used_apply->exhibit_list = $exhibit_sum_register_ids;
        $exhibit_used_apply->save();
        return $this->success('oustorageapply',"保存成功");
    }

    /**
     * 出库申请提交审核
     */
    public function oustorageapply_submit(){
        $exhibit_used_apply_ids = \request('exhibit_used_apply_id');
        if(empty($exhibit_used_apply_ids)){
            return $this->error('参数错误');
        }
        $count = ExhibitUsedApply::whereIn('exhibit_used_apply_id', $exhibit_used_apply_ids)->where('status','!=', ConstDao::EXHIBIT_USED_APPLY_STATUS_DRAFT)->count();
        if($count>0){
            return $this->error('抱歉，选择项中存在已审核的申请单');
        }
        ExhibitUsedApply::whereIn('exhibit_used_apply_id', $exhibit_used_apply_ids)->update(array('status'=>ConstDao::EXHIBIT_USED_APPLY_STATUS_WAITING_AUDIT));
        return $this->success('oustorageapply','提交审核成功');
    }

    /**
     * 藏品出库
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function exhibitout(){
        $exhibit_list = ExhibitUse::get();
        $res['exhibit_list'] = $exhibit_list;
        return view('admin.exhibitmanage.exhibitout_list', $res);
    }

    /**
     * 增加藏品出库
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_exhibitout(){
        $exhibit_use_id = \request('exhibit_use_id');
        if(empty($exhibit_use_id)){
            $exhibit_use_model = ExhibitUse::where('exhibit_use_id', $exhibit_use_id)->first();
            if(empty($exhibit_use_model)){
                return $this->error('暂时不能支持添加出库单据');
            }
        }else{
            $exhibit_use_model = ExhibitUse::where('exhibit_use_id', $exhibit_use_id)->first();
        }
        $res['exhibit_use_info'] = $exhibit_use_model;
        $items = ExhibitUseItem::join('exhibit','exhibit.exhibit_sum_register_id','=','exhibit_use_item.exhibit_sum_register_id')
            ->where('exhibit_use_id', $exhibit_use_id)->select('exhibit_use_item_id', 'exhibit_sum_register_num','name',
                DB::Raw('ldc_exhibit_use_item.num as t_num'),'exhibit_level', 'backup_time',
                'complete_degree',DB::Raw('ldc_exhibit_use_item.backup as t_backup'))->get();
        $res['exhibit_list'] = $items;
        return view('admin.exhibitmanage.add_exhibitout', $res);
    }

    /**
     * 出库信息保存
     */
    public function exhibitout_save(){
        $exhibit_use_id = \request('exhibit_use_id');
        $exhibit_use = ExhibitUse::where('exhibit_use_id', $exhibit_use_id)->first();
        if(empty($exhibit_use)){
            return $this->error('参数错误');
        }
        $exhibit_use->depart_name = \request('depart_name');
        $exhibit_use->outer_destination = \request('outer_destination');
        $exhibit_use->outer_time = \request('outer_time');
        $exhibit_use->outer_sender = \request('outer_sender');
        $exhibit_use->outer_taker = \request('outer_taker');
        $exhibit_use->date = \request('date');
        $type = \request('type');
        $exhibit_use->type = $type;
            $exhibit_use->save();
        $items = ExhibitUseItem::where('exhibit_use_id', $exhibit_use_id)->get();
        foreach($items as $item){
            $item->num = \request($item->exhibit_use_item_id.'_num');
            $item->backup_time = \request($item->exhibit_use_item_id.'_backup_time');
            $item->backup = \request($item->exhibit_use_item_id.'_backup');
            //修改展品的状态
            $exhibit = Exhibit::where('exhibit_sum_register_id', $item->exhibit_sum_register_id)->first();
            if(!empty($exhibit)){
                $exhibit->status = $type;
                $exhibit->save();
            }
            $item->save();
        }
        return $this->success('exhibitout','操作成功');
    }
}
