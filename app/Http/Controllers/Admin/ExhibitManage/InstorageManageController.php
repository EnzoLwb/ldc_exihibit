<?php

namespace App\Http\Controllers\Admin\ExhibitManage;

use App\Dao\ConstDao;
use App\Models\Exhibit;
use App\Models\Exhibit2Room;
use App\Models\ExhibitUse;
use App\Models\ExhibitUsedApply;
use App\Models\ExhibitUseItem;
use App\Models\Frame;
use App\Models\Storageroommanage\StorageRoom;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class InstorageManageController extends BaseAdminController
{
    /**
     * 入库管理列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $title = \request('title');
        if(empty($title)){
            $list = Exhibit2Room::join('exhibit','exhibit.exhibit_sum_register_id','=','exhibit_into_room.exhibit_sum_register_id')->join('storage_room',
                'storage_room.room_number','=','exhibit_into_room.room_number')->select(
                DB::Raw('ldc_exhibit_into_room.status'),'exhibit_into_room_id','in_room_recipe_num',DB::Raw('ldc_exhibit.name'),'room_name')
                ->where('exhibit_into_room.type', ConstDao::ACCOUNT_SUM)->get()->toArray();
            $list_2 = Exhibit2Room::join('subsidiary','subsidiary.subsidiary_id','=','exhibit_into_room.exhibit_sum_register_id')->join('storage_room',
                'storage_room.room_number','=','exhibit_into_room.room_number')->select(
                DB::Raw('ldc_exhibit_into_room.status'),'exhibit_into_room_id','in_room_recipe_num',DB::Raw('ldc_subsidiary.name'),'room_name')
                ->where('exhibit_into_room.type', ConstDao::ACCOUNT_SUB)->get()->toArray();

            $list = array_merge($list, $list_2);
        }else{
            $list = Exhibit2Room::join('exhibit','exhibit.exhibit_sum_register_id','=','exhibit_into_room.exhibit_sum_register_id')->join('storage_room',
                'storage_room.room_number','=','exhibit_into_room.room_number')->select(
                DB::Raw('ldc_exhibit_into_room.status'),'exhibit_into_room_id','in_room_recipe_num',DB::Raw('ldc_exhibit.name'),'room_name')
                ->where('exhibit_into_room.type', ConstDao::ACCOUNT_SUM)->where('exhibit.name', 'like','%'.$title.'%')->get()->toArray();
            $list_2 = Exhibit2Room::join('subsidiary','subsidiary.subsidiary_id','=','exhibit_into_room.exhibit_sum_register_id')->join('storage_room',
                'storage_room.room_number','=','exhibit_into_room.room_number')->select(
                DB::Raw('ldc_exhibit_into_room.status'),'exhibit_into_room_id','in_room_recipe_num',DB::Raw('ldc_subsidiary.name'),'room_name')
                ->where('exhibit_into_room.type', ConstDao::ACCOUNT_SUB)->where('subsidiary.name', 'like','%'.$title.'%')->get()->toArray();
            $list = array_merge($list, $list_2);
        }
        $total = count($list); //记录总条数
        $perPage =parent::PERPAGE; //每页的记录数 ( 常量 )
        $current_page = \request('page',1); // 当前页
        $path = Paginator::resolveCurrentPath(); // 获取当前的链接"http://localhost/admin/account"
        $list = array_slice($list, ($current_page-1)*$perPage,$perPage);
        $infoList['paginator'] = new LengthAwarePaginator($list, $total,$perPage, $current_page, [
            'path' => $path ,  //设定个要分页的url地址。也可以手动通过 $paginator ->setPath(‘路径’) 设置
            'pageName' => 'page', //链接的参数名 http://localhost/admin/manage?page=2
        ]);
        $res['exhibit_list'] = $list;
        $res['paginator'] = $infoList['paginator'];
        $res['exhibit_list'] = $list;
        return view('admin.exhibitmanage.instorage_list', $res);
    }

    /**
     * 增加入库记录（实际上试修改展品信息）
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_instorageroom()
    {
        $exhibit_into_room_id = \request('exhibit_into_room_id');
        $exhibit2room = Exhibit2Room::where('exhibit_into_room_id', $exhibit_into_room_id)->first();
        $exhibit_not_can_used = Exhibit2Room::where('status',ConstDao::EXHIBIT_INTO_ROOM_STATUS_WAITING_AUDIT)->get();
        $exhibit_not_can_used_ids = array();
        foreach($exhibit_not_can_used as $item){
            $exhibit_not_can_used_ids[] = $item->exhibit_sum_register_id;
        }

        if(!empty($exhibit_not_can_used_ids)){
            if(!empty($exhibit2room)){
                $list = Exhibit::whereNotIn('exhibit_sum_register_id', $exhibit_not_can_used_ids)->orwhere('exhibit_sum_register_id','=',
                    $exhibit2room->exhibit_sum_register_id)->get()->toArray();
            }else{
                $list = Exhibit::whereNotIn('exhibit_sum_register_id', $exhibit_not_can_used_ids)->get()->toArray();
            }
        }else{
                $raw =  Exhibit::where('room_number', '')->get()->toArray();
                $list = array();
                foreach($raw as $item){

                    if(empty($item['room_number']))
                    {
                        $list[]=['exhibit_sum_register_id'=>$item['exhibit_sum_register_id']];
                    }
                }
        }

        //获得exhibit_id
        $exhibit_sum_register_ids = array();
        foreach($list as $item){
            $exhibit_sum_register_ids[] = $item['exhibit_sum_register_id'];
        }

        if(!empty($exhibit_sum_register_ids)){
            $list = Exhibit::whereIn('exhibit_sum_register_id', $exhibit_sum_register_ids)->where('room_number', '')->get()->toArray();
        }
        if(empty($list)){
            return $this->error('暂无可入库的展品');
        }

        $res['exhibit_list'] = $list;
        $res['room_list'] = StorageRoom::all();
        $res['info'] = $exhibit2room;
        //修改申请信息
        return view('admin.exhibitmanage.add_instorage', $res);
    }


    /**
     * 审核成功
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function submit_instorageroom(){
        $exhibit_into_room_id = \request('exhibit_into_room_id');
        if(empty($exhibit_into_room_id) || !is_array($exhibit_into_room_id)){
            return response_json(0,[],'参数有误');
        }
        $count = Exhibit2Room::where('status', '!=',ConstDao::EXHIBIT_INTO_ROOM_STATUS_DRAFT)->whereIn('exhibit_into_room_id', $exhibit_into_room_id)->count();
        if($count>0){
            return response_json(0,[],'包含已审核的项');
        }
        Exhibit2Room::whereIn('exhibit_into_room_id', $exhibit_into_room_id)->update(array('status'=>ConstDao::EXHIBIT_INTO_ROOM_STATUS_WAITING_AUDIT));
        return response_json(1,[],'提交审核');
    }

    /**
     * 入库信息保存
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function instorageroom_save(Request $request)
    {
        $exhibit_into_room_id = \request('exhibit_into_room_id');
        $exhibit2room = Exhibit2Room::findOrNew($exhibit_into_room_id);
        if(empty(\request('exhibit_sum_register_id')) || empty(\request('room_number')) || empty(\request('in_room_recipe_num'))){
            return $this->error('参数有误');
        }
        $exhibit2room->type = \request('type');
        $exhibit2room->exhibit_sum_register_id = \request('exhibit_sum_register_id');
        $exhibit2room->room_number = \request('room_number');
        $exhibit2room->in_room_recipe_num = \request('in_room_recipe_num');
        $exhibit2room->frame_id = \request('frame_id');
        $exhibit2room->status = ConstDao::EXHIBIT_INTO_ROOM_STATUS_DRAFT;
        $exhibit2room->save();
        return $this->success('instorageroom', '保存成功');
    }

    /**
     *  出库申请
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function oustorageapply()
    {
        $executer = \request('executer');
        if (empty($executer)) {
            $list = ExhibitUsedApply::paginate(parent::PERPAGE);
        } else {
            $list = ExhibitUsedApply::where('executer', 'like', '%' . $executer . "%")->paginate(parent::PERPAGE);
        }
        foreach ($list as $key => $item) {
            $exhibit_ids = $item->exhibit_list;
            $exhibit_ids = \json_decode($exhibit_ids, true);
            $list[$key]->apply_type = $exhibit_ids['type'];
            $exhibit_ids = $exhibit_ids['ids'];
            $exhibits = array();
            $names = '';
            if (!empty($exhibit_ids)) {
                if($list[$key]->apply_type == ConstDao::ACCOUNT_SUM){
                    $exhibits = Exhibit::whereIn('exhibit_sum_register_id', $exhibit_ids)->get();
                }else{
                    $exhibits = Subsidiary::whereIn('subsidiary_id', $exhibit_ids)->get();
                }

            }
            foreach ($exhibits as $exhibit) {
                $names .= $exhibit->name . ",";
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
    public function add_oustorageapply()
    {
        $exhibit_used_apply_id = \request('exhibit_used_apply_id');
        $info = ExhibitUsedApply::where('exhibit_used_apply_id', $exhibit_used_apply_id)->first();
        $res['info'] = $info;
        return view('admin.exhibitmanage.add_oustorageapply', $res);
    }

    /**
     * 新增辅助文物出库申请
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_sub_oustorageapply(){
        $exhibit_used_apply_id = \request('exhibit_used_apply_id');
        $info = ExhibitUsedApply::where('exhibit_used_apply_id', $exhibit_used_apply_id)->first();
        $res['info'] = $info;
        return view('admin.exhibitmanage.add_sub_oustorageapply', $res);
    }

    /**
     * 保存出库申请的相关信息
     */
    public function oustorageapply_save()
    {
        $exhibit_used_apply_id = \request('exhibit_used_apply_id');
        $exhibit_used_apply = ExhibitUsedApply::findOrNew($exhibit_used_apply_id);
        $exhibit_used_apply->apply_depart_name = \request('apply_depart_name');
        $exhibit_used_apply->executer = \request('executer');
        $exhibit_used_apply->connectioner = \request('connectioner');
        $exhibit_used_apply->phone = \request('phone');
        $exhibit_used_apply->outer_time = \request('outer_time');
        $exhibit_used_apply->outer_destination = \request('outer_destination');
        $exhibit_sum_register_ids = \request('exhibit_sum_register_id');
        if (empty($exhibit_sum_register_ids)) {
            return $this->error('请选择展品');
        }
        $exhibit_used_apply->type = ConstDao::EXHIBIT_USED_OUTER;
        $exhibit_used_apply->status = ConstDao::EXHIBIT_USED_APPLY_STATUS_DRAFT;
        $type = \request('type');
        $ids = array();
        $raw_ids = explode(',', $exhibit_sum_register_ids);
        foreach($raw_ids as $id){
            if(!empty($id)){
                $ids[] = $id;
            }
        }
        $exhibit_id_list = array('type'=>$type, 'ids'=>$ids);
        $exhibit_used_apply->exhibit_list = \json_encode($exhibit_id_list);
        $exhibit_used_apply->save();
        return $this->success('oustorageapply', "保存成功");
    }

    /**
     * 出库申请提交审核
     */
    public function oustorageapply_submit()
    {
        $exhibit_used_apply_ids = \request('exhibit_used_apply_id');
        if (empty($exhibit_used_apply_ids)) {
            return $this->error('参数错误');
        }
        $count = ExhibitUsedApply::whereIn('exhibit_used_apply_id', $exhibit_used_apply_ids)->where('status', '!=', ConstDao::EXHIBIT_USED_APPLY_STATUS_DRAFT)->count();
        if ($count > 0) {
            return $this->error('抱歉，选择项中存在已审核的申请单');
        }
        ExhibitUsedApply::whereIn('exhibit_used_apply_id', $exhibit_used_apply_ids)->update(array('status' => ConstDao::EXHIBIT_USED_APPLY_STATUS_WAITING_AUDIT));
        return $this->success('oustorageapply', '提交审核成功');
    }

    /**
     * 藏品出库
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function exhibitout()
    {
        $exhibit_list = ExhibitUse::paginate(parent::PERPAGE);
        $res['exhibit_list'] = $exhibit_list;
        return view('admin.exhibitmanage.exhibitout_list', $res);
    }

    /**
     * 增加藏品出库
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_exhibitout()
    {
        $exhibit_use_id = \request('exhibit_use_id');
        if (empty($exhibit_use_id)) {
            $exhibit_use_model = ExhibitUse::where('exhibit_use_id', $exhibit_use_id)->first();
            if (empty($exhibit_use_model)) {
                return $this->error('暂时不能支持添加出库单据');
            }
        } else {
            $exhibit_use_model = ExhibitUse::where('exhibit_use_id', $exhibit_use_id)->first();
        }
        $res['exhibit_use_info'] = $exhibit_use_model;
        $items_1 = ExhibitUseItem::join('exhibit', 'exhibit.exhibit_sum_register_id', '=', 'exhibit_use_item.exhibit_sum_register_id')
            ->where('exhibit_use_id', $exhibit_use_id)->where('exhibit_use_item.type', ConstDao::ACCOUNT_SUM)->select('exhibit_use_item_id', 'exhibit_sum_register_num', 'name',
                DB::Raw('ldc_exhibit_use_item.num as t_num'), 'exhibit_level', 'backup_time',
                'complete_degree', DB::Raw('ldc_exhibit_use_item.backup as t_backup'))->get()->toArray();
        $items_2 = ExhibitUseItem::join('subsidiary', 'subsidiary.subsidiary_id', '=', 'exhibit_use_item.exhibit_sum_register_id')
            ->where('exhibit_use_id', $exhibit_use_id)->where('exhibit_use_item.type', ConstDao::ACCOUNT_SUB)
            ->select('exhibit_use_item_id', 'exhibit_sum_register_num', 'name',
                DB::Raw('ldc_exhibit_use_item.num as t_num'),  'backup_time',
                 DB::Raw('ldc_exhibit_use_item.backup as t_backup'))->get()->toArray();
        foreach ($items_2 as $k=>$v){
            $items_2[$k]['exhibit_level'] = '一级';
            $items_2[$k]['complete_degree'] = '未知';
        }

        $res['exhibit_list'] = array_merge($items_1, $items_2);
        return view('admin.exhibitmanage.add_exhibitout', $res);
    }

    /**
     * 出库信息保存
     */
    public function exhibitout_save()
    {
        $exhibit_use_id = \request('exhibit_use_id');
        $exhibit_use = ExhibitUse::where('exhibit_use_id', $exhibit_use_id)->first();
        if (empty($exhibit_use)) {
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
        foreach ($items as $item) {
            $item->num = \request($item->exhibit_use_item_id . '_num');
            $item->backup_time = \request($item->exhibit_use_item_id . '_backup_time');
            $item->backup = \request($item->exhibit_use_item_id . '_backup');
            //修改展品的状态
            $exhibit = Exhibit::where('exhibit_sum_register_id', $item->exhibit_sum_register_id)->first();
            if (!empty($exhibit)) {
                $exhibit->status = $type;
                $exhibit->save();
            }
            $item->save();
        }
        return $this->success('exhibitout', '操作成功');
    }


    /**
     * 根据库房ID获得 所有架子
     * @return \Illuminate\Http\JsonResponse
     */
    public function frame_list(){
        $room_number = \request('room_number');
        $list = Frame::where('room_number', $room_number)->get()->toArray();
        $list[] = array('frame_id'=>0, 'frame_name'=>'无需排架');
        return response_json(1, $list,'');
    }
}
