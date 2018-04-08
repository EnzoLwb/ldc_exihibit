<?php

namespace App\Http\Controllers\Admin\ExhibitManage;

use App\Models\Exhibit;
use App\Models\Storageroommanage\StorageRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseAdminController;

class IndexController extends BaseAdminController
{

    /**
     * 仓库列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function storageroom(){
        $res['exhibit_list'] = Exhibit::join('storage_room','storage_room.room_number','=','exhibit.room_number','left')
            ->select('exhibit_sum_register_id','exhibit_sum_register_num','name','room_name')->get();
        return view('admin.exhibitmanage.stroageroom_list', $res);
    }

    /**
     * 新建仓库的页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_storageroom(){
        $exhibit_sum_register_id = \request('exhibit_sum_register_id');
        $exhibit = Exhibit::where('exhibit_sum_register_id', $exhibit_sum_register_id)->first();
        if(empty($exhibit)){
            return $this->error('参数有误');
        }
        $list = StorageRoom::get();
        $res['exhibit_list'] = $list;
        $res['exhibit_sum_register_id'] = $exhibit_sum_register_id;
        return view('admin.exhibitmanage.add_storageroom', $res);
    }

    /**
     * 保存展品所在仓库信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function storage_room_save(){
        $room_number = \request('room_number');
        $exhibit_sum_register_id = \request('exhibit_sum_register_id');
        //判断这俩参数是不是正确的
        $room = StorageRoom::where('room_number', $room_number)->first();
        $exhibit = Exhibit::where('exhibit_sum_register_id',$exhibit_sum_register_id)->first();
        if(empty($room) || empty($exhibit)){
            return $this->error('参数有误');
        }
        $exhibit->room_number = $room_number;
        $exhibit->save();
        return $this->success('storageroom','操作完成');
    }
}
