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
        $item['sum_register_num'] = 'GTR667';
        $item['enter_museum_num'] = 'fr6543';
        $item['name'] = '大禹治水...';
        $item['count'] = '1';
        $item['age'] = '石器时代';
        $item['class'] = '';
        $item['size'] = '10寸';
        $item['weight'] = '100克';
        $item['current_info'] = '完好';
        $item['room_num'] = '1号';
        $item['enter_museum_date'] = '2018-03-20';
        $item['src'] = '直接入馆';
        $item['recipe_num'] = '32123';


        $item1['sum_register_num'] = 'GTR668';
        $item1['enter_museum_num'] = 'fr6544';
        $item1['name'] = '玉龙吊坠...';
        $item1['count'] = '1';
        $item1['age'] = '石器时代';
        $item1['class'] = '';
        $item1['size'] = '10寸';
        $item1['weight'] = '100克';
        $item1['current_info'] = '完好';
        $item1['room_num'] = '1号';
        $item1['enter_museum_date'] = '2018-03-20';
        $item1['src'] = '直接入馆';
        $item1['recipe_num'] = '32127';
        $res['exhibit_list'] = array($item,$item1);
        return view('admin.exhibitmanage.instorage_list', $res);
    }

    /**
     * 增加入库记录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_instorageroom(){
        return view('admin.exhibitmanage.add_instorage');
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
        $exhibit_use->type = \request('type');
        $exhibit_use->save();
        $items = ExhibitUseItem::where('exhibit_use_id', $exhibit_use_id)->get();
        foreach($items as $item){
            $item->num = \request($item->exhibit_use_item_id.'_num');
            $item->backup_time = \request($item->exhibit_use_item_id.'_backup_time');
            $item->backup = \request($item->exhibit_use_item_id.'_backup');
            $item->save();
        }
        return $this->success('exhibitout','操作成功');
    }
}
