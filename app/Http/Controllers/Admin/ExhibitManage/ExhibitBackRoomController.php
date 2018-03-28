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
        $res['exhibit_list'] = array();
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
