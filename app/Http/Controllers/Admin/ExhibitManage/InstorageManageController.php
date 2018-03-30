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
        $item['sum_register_num'] = 'GTR667';
        $item['enter_museum_num'] = 'fr6543';
        $item['name'] = '大禹治水...';
        $item['count'] = '1';
        $item['age'] = '石器时代';
        $item['class'] = '';
        $item['size'] = '10寸';
        $item['weight'] = '100克';
        $item['current_info'] = '完好';
        $item['room_num'] = '1号';
        $item['enter_museum_date'] = '2018-03-20';
        $item['src'] = '直接入馆';
        $item['recipe_num'] = '32123';


        $item1['sum_register_num'] = 'GTR668';
        $item1['enter_museum_num'] = 'fr6544';
        $item1['name'] = '玉龙吊坠...';
        $item1['count'] = '1';
        $item1['age'] = '石器时代';
        $item1['class'] = '';
        $item1['size'] = '10寸';
        $item1['weight'] = '100克';
        $item1['current_info'] = '完好';
        $item1['room_num'] = '1号';
        $item1['enter_museum_date'] = '2018-03-20';
        $item1['src'] = '直接入馆';
        $item1['recipe_num'] = '32127';
        $res['exhibit_list'] = array($item,$item1);
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
        $item['apply_departname'] = '陈展部';
        $item['apply_name'] = '张三';
        $item['connector_name'] = '张三';
        $item['connector_phone'] = '13657890345';
        $item['out_date'] = '2018-03-10';
        $item['exhibit_list'] = '大玉龙，祺皇贵妃..';
        $item['destination'] = '参加展览';

        $item1['apply_departname'] = '陈展部';
        $item1['apply_name'] = '李四';
        $item1['connector_name'] = '李四';
        $item1['connector_phone'] = '13657490876';
        $item1['out_date'] = '2018-03-10';
        $item1['exhibit_list'] = '古玉吊坠';
        $item1['destination'] = '修复';
        $res['exhibit_list'] = array($item, $item1);
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
        $item['depart_name'] = '陈展部';
        $item['destion'] = '展览使用';
        $item['out_date'] = '2018-03-10';
        $item['action_name'] = '张三';
        $item['taker_name'] = '王五';
        $item1['depart_name'] = '陈展部';
        $item1['destion'] = '展览使用';
        $item1['out_date'] = '2018-03-10';
        $item1['action_name'] = '李四';
        $item1['taker_name'] = '王五';
        $res['exhibit_list'] = array($item, $item1);
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
