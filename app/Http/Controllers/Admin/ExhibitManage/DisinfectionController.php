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
        $item['name'] = '玉神人...';
        $item['sum_register_num'] = 'MM42432';
        $item['clean_way'] = '吹风';
        $item['disinfection_way'] = '干吹';
        $item['apply_depart'] = '文物管理部';
        $item['date'] = '2018-03-30';
        $item1['name'] = '大玉龙...';
        $item1['sum_register_num'] = 'MM42433';
        $item1['clean_way'] = '吹风';
        $item1['disinfection_way'] = '干吹';
        $item1['apply_depart'] = '文物管理部';
        $item1['date'] = '2018-03-30';
        $res['exhibit_list'] = array($item, $item1);
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
