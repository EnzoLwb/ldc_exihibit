<?php

namespace App\Http\Controllers\Admin\ExhibitManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseAdminController;

class TransferController extends BaseAdminController
{

    /**
     * 移库管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $res['exhibit_list'] = array();
        return view('admin.exhibitmanage.transfer_list', $res);
    }


    /**
     * 增加移库管理记录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_transfer(){
        return view('admin.exhibitmanage.add_transfer');
    }
}
