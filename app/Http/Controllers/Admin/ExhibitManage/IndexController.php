<?php

namespace App\Http\Controllers\Admin\ExhibitManage;

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
        $res['exhibit_list'] = array(array('name'=>'珍宝库'),array('name'=>'902仓库'),array('name'=>'327工作室'));
        return view('admin.exhibitmanage.stroageroom_list', $res);
    }

    /**
     * 新建仓库的页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_storageroom(){
        return view('admin.exhibitmanage.add_stroageroom');
    }
}
