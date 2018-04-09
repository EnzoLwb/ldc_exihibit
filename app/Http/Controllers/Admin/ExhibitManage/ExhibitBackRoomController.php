<?php

namespace App\Http\Controllers\Admin\ExhibitManage;

use App\Dao\ConstDao;
use App\Models\Exhibit;
use App\Models\ReturnStorage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExhibitBackRoomController extends BaseAdminController
{
    /**
     * 藏品回库记录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
       $list = ReturnStorage::join('exhibit','exhibit.exhibit_sum_register_id','=','return_storage.exhibit_sum_register_id')->
           select('name','returner','taker','return_date','return_storage_id','mark',DB::Raw('ldc_return_storage.status as status'))->paginate(parent::PERPAGE);
       $res['exhibit_list'] = $list;
       return view('admin.exhibitmanage.exhibitbackroom_list', $res);
    }

    /**
     * 增加藏品回库记录展示页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_exhibitbackroom(){
        $return_storage_id = \request('return_storage_id');
        $exhibit_list = Exhibit::where('status', '!=', ConstDao::EXHIBIT_STATUS_IN_ROOM)->get();
        if(count($exhibit_list) ==0){
            return $this->error('暂无可回库的藏品');
        }
        $return_storage_model = ReturnStorage::findOrNew($return_storage_id);
        $res['info'] = $return_storage_model;
        $res['exhibit_list'] = $exhibit_list;
        return view('admin.exhibitmanage.add_exhibitbackroom', $res);
    }

    /**
     * 展品回库信息保存
     */
    public function save_exhibitbackroom(Request $request){
        $return_storage_id = \request('return_storage_id');
        $return_storage_model = ReturnStorage::findOrNew($return_storage_id);
        $all = $request->all();
        $except = array('_token');
        foreach($all as $k=>$v){
            if(!in_array($k, $except)){
                $return_storage_model->$k = $v;
            }
        }$return_storage_model->status = ConstDao::RETURNSTORAGE_STATUS_DRAFT;
        $return_storage_model->recorder = Auth::user()->username;
        $return_storage_model->save();

        return $this->success('exhibitbackroom','保存成功');
    }

    /**
     * 藏品回库提交
     */
    public function submit_exhibitbackroom(){
        $return_storage_id = \request('return_storage_id');
        if(empty($return_storage_id) || !is_array($return_storage_id)){
            return response_json(0,array(),'参数有误');
        }
        $count  = ReturnStorage::where('status', ConstDao::RETURNSTORAGE_STATUS_SUBMIT)->whereIn('return_storage_id', $return_storage_id)->count();
        if($count>0){
            return response_json(0,array(),'包含已提交的项');
        }
        DB::transaction(function () use($return_storage_id) {
            ReturnStorage::whereIn('return_storage_id',$return_storage_id)->update(array('status'=>ConstDao::RETURNSTORAGE_STATUS_SUBMIT));
            //修改展品的状态
            $list = ReturnStorage::whereIn('return_storage_id',$return_storage_id)->value('exhibit_sum_register_id');
            Exhibit::where('exhibit_sum_register_id', $list)->update(array('status'=>ConstDao::EXHIBIT_STATUS_IN_ROOM));
        });
        return response_json(1,array(),'提交成功');
    }
}
