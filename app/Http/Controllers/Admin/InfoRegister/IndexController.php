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
        $item['sum_num'] = 'WW2301';
        $item['ori_num'] = '002';
        $item['last_num'] = '02';
        $item['in_museum_num'] = 'RGDJ0001';
        $item['name'] = '三孔玉刀';
        $item['last_name'] = '三孔玉刀';
        $item['history_'] ='制造年代';
        $item['juti_history'] = '新石器时代';
        $item['history_jieduan'] = '';
        $item['zhidi_leixing'] = '无机质';
        $item1['sum_num'] = 'WW00561';
        $item1['ori_num'] = '003';
        $item1['last_num'] = '03';
        $item1['in_museum_num'] = 'RG0036';
        $item1['name'] = '大玉龙';
        $item1['last_name'] = '大玉龙';
        $item1['history_'] ='出土年代';
        $item1['juti_history'] = '新石器时代';
        $item1['history_jieduan'] = '';
        $item1['zhidi_leixing'] = '其他有机质';
        $res['exhibit_list'] = array($item, $item1);
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
        $item['collect_depart'] = '文物部';
        $item['sum_num'] = '0036';
        $item['class_num'] = '01';
        $item['in_museum_num'] = 'RG003';
        $item['name'] = '玉立人';
        $item['ori_name'] = '玉立人';
        $item['niandai_leixing'] = '出土年代';
        $item['juti_niandai'] = '新石器时代';
        $item['history_'] = '';

        $item1['collect_depart'] = '文物部';
        $item1['sum_num'] = 'ZZDJH002';
        $item1['class_num'] = '002';
        $item1['in_museum_num'] = 'RG00056';
        $item1['name'] = '经箱';
        $item1['ori_name'] = '经箱';
        $item1['niandai_leixing'] = '出土年代';
        $item1['juti_niandai'] = '开元年';
        $item1['history_'] = '';
        $res['exhibit_list'] = array($item,$item1);
        return view('admin.inforegister.subsidiary', $res);
    }

    /**
     * 添加辅助账种类
     */
    public function add_subsidiary(){
        return view('admin.inforegister.add_subsidiary');
    }
}
