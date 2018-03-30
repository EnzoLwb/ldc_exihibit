<?php

namespace App\Http\Controllers\Admin\ExhibitManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseAdminController;

class AccidentRegistrationController extends BaseAdminController
{
    public function index(){
        $item['exhibit_name'] = '铜制...';
        $item['sum_register_num'] = 'ARER425424';
        $item['accident_date'] = '2018-01-10';
        $item['accident_maker'] = '张三';
        $item['accident_desc'] = '搬运过程中磕碰';
        $item['handle_dependy'] = '惯例';
        $item['handle_result'] = '修复';

        $item1['exhibit_name'] = '万国来朝图';
        $item1['sum_register_num'] = 'ARER425440';
        $item1['accident_date'] = '2018-01-10';
        $item1['accident_maker'] = '张三';
        $item1['accident_desc'] = '搬运过程中磕碰';
        $item1['handle_dependy'] = '开会决定';
        $item1['handle_result'] = '修复';
        $res['exhibit_list'] = array($item, $item1);
        return view('admin.exhibitmanage.accidentregistration_list', $res);
    }

    /**
     * 增加事故登记
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_accidentregistration(){
        return view('admin.exhibitmanage.add_accidentregistration');
    }
}
