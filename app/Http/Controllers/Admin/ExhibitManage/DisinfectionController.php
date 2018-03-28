<?php

namespace App\Http\Controllers\Admin\ExhibitManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseAdminController;

class DisinfectionController extends BaseAdminController
{

    /**
     * 消毒登记列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function index(){
        $res['exhibit_list'] = array();
        return view('admin.exhibitmanage.disinfection_list', $res);
    }

    /**
     * 增加消毒记录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_disinfection(){
        return view('admin.exhibitmanage.add_disinfection');
    }
}
