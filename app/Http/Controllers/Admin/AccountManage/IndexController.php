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
        $item['apply_num'] = 'WW2301';
        $item['apply_depart_name'] = '001';
        $item['apply_buy_object'] = '001';
        $item['project_name'] = 'RGDJ009';
        $item['depart_name'] = '大玉龙';
        $item['need_money'] = '大玉龙';
        $item['need_count'] = '出土年代';
        $item['applyer'] = '新石器时代';
        $item['project_desc'] = '';
        $item['apply_reason'] = '宝玉石';
        $item['...'] = '...';
        $res['exhibit_list'] = array($item);
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
