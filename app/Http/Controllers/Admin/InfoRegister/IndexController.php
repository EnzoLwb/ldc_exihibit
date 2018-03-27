<?php

namespace App\Http\Controllers\Admin\InfoRegister;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Http\Controllers\Admin\BaseAdminController;

class IndexController extends BaseAdminController
{
    /**
     * 馆藏文物管理
     */
    public function exhibitmanage(){
        $res['exhibit_list'] = array();
        return view('admin.inforegister.exhibit',$res);
    }

    /**
     * 新增文物信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_exhibit(){
        return view('admin.inforegister.add_exhibit');
    }

    /**
     * 选择辅助账种类
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subsidiary(){
        $res['exhibit_list'] = array();
        return view('admin.inforegister.subsidiary', $res);
    }

    /**
     * 添加辅助账种类
     */
    public function add_subsidiary(){
        return view('admin.inforegister.add_subsidiary');
    }
}
