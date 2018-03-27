<?php

namespace App\Http\Controllers\Admin\ExhibitCollect;
use App\Http\Controllers\Admin\BaseAdminController;

class ExhibitController extends BaseAdminController
{

    /**
     * 征集申请web页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function apply(){
        $res['exhibit_list'] = array();
        return view('admin.exhibitcollect.apply', $res);
    }

    /**
     * 新增征集申请
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        return view('admin.exhibitcollect.add');
    }

    /**
     * 申请保存信息
     */
    public function apply_save(){
        return $this->success( get_session_url('apply'),'保存成功');
    }

    public function getin(){
        $res['exhibit_list'] = array();
        return view('admin.exhibitcollect.getin',$res);
    }

    public function getin_add(){
        $res['exhibit_list'] = array();
        return view('admin.exhibitcollect.getin_add', $res);
    }

    public function getin_save(){
        return $this->success( get_session_url('getin'), '保存成功');
    }
}
