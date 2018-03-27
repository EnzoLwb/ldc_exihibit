<?php

namespace App\Http\Controllers\Admin\AccountManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Http\Controllers\Admin\BaseAdminController;

class IndexController extends BaseAdminController
{

    /**
     * 总账列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sumaccount(){
        $res['exhibit_list'] = array();
        return view('admin.accountmanage.sumaccount', $res);
    }


    /**
     * 总账修改
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_sumaccount(){
        return view('admin.accountmanage.add_sumaccount');
    }


    /**
     * 辅助账列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subsidiary(){
        $res['exhibit_list'] =  array();
        return view('admin.accountmanage.subsidiary', $res);
    }

    /**
     * 新增辅助账列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_subsidiary(){
        return view('admin.accountmanage.add_subsidiary');
    }
}
