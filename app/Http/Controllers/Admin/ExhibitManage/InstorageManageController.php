<?php

namespace App\Http\Controllers\Admin\ExhibitManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseAdminController;

class InstorageManageController extends BaseAdminController
{
    /**
     * 入库管理列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $res['exhibit_list'] = array();
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
        $res['exhibit_list'] = array();
        return view('admin.exhibitmanage.oustorageapply_list', $res);
    }

    /**
     * 增加出库申请
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_oustorageapply(){

        return view('admin.exhibitmanage.add_oustorageapply');
    }


    /**
     * 藏品出库
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function exhibitout(){
        $res['exhibit_list'] = array();
        return view('admin.exhibitmanage.exhibitout_list', $res);
    }

    /**
     * 增加藏品出库
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_exhibitout(){
        $res['exhibit_list'] = array();
        return view('admin.exhibitmanage.add_exhibitout',$res);
    }
}
