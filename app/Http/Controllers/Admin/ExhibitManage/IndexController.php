<?php

namespace App\Http\Controllers\Admin\ExhibitManage;

use App\Models\Exhibit;
use App\Models\Storageroommanage\StorageRoom;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class IndexController extends BaseAdminController
{

    /**
     * 仓库列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function storageroom(){
        $title = \request('title');
        // 移库管理
        if(empty($title)){
            //获得藏品信息
            $list = Exhibit::join('storage_room','storage_room.room_number','=','exhibit.room_number')
                ->select('exhibit_sum_register_id','exhibit_sum_register_num','name','room_name')->get()->toArray();
            $list_2 = Subsidiary::join('storage_room','storage_room.room_number','=','subsidiary.room_number')
                ->select(DB::Raw('ldc_subsidiary.subsidiary_id as exhibit_sum_register_id'),'exhibit_sum_register_num','name','room_name')->get()->toArray();
            $list = array_merge($list, $list_2);
        }else{
            $list = Exhibit::join('storage_room','storage_room.room_number','=','exhibit.room_number')
                ->where('name','like', '%'.$title."%")->select('exhibit_sum_register_id','exhibit_sum_register_num','name','room_name')->get()->toArray();
            $list_2 = Subsidiary::join('storage_room','storage_room.room_number','=','subsidiary.room_number')
                ->where('name','like', '%'.$title."%")
                ->select(DB::Raw('ldc_subsidiary.subsidiary_id as exhibit_sum_register_id'),'exhibit_sum_register_num','name','room_name')->get()->toArray();
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
        $res['info'] = $exhibit;
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
        $exhibit->frame_id = \request('frame_id');
        $exhibit->save();
        return $this->success('storageroom','操作完成');
    }

}
