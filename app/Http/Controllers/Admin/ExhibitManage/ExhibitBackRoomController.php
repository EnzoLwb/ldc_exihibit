<?php

namespace App\Http\Controllers\Admin\ExhibitManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseAdminController;

class ExhibitBackRoomController extends BaseAdminController
{
    /**
     * 藏品回库记录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $item['sum_register_num'] ='QEC3424';
        $item['exhibit_name'] ='雕龙玉佩';
        $item['backer_name'] = '张三';
        $item['taker_name'] = '李四';
        $item['back_date'] = '2018-03-10';
        $item['backup'] = '';
        $item1['sum_register_num'] ='QEC3445';
        $item1['exhibit_name'] ='雕龙玉坠';
        $item1['backer_name'] = '张三';
        $item1['taker_name'] = '李四';
        $item1['back_date'] = '2018-03-10';
        $item1['backup'] = '';
        $res['exhibit_list'] = array($item, $item1);
        return view('admin.exhibitmanage.exhibitbackroom_list', $res);
    }

    /**
     * 增加藏品回库记录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_exhibitbackroom(){
        return view('admin.exhibitmanage.add_exhibitbackroom');
    }
}
