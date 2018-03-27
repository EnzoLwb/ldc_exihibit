<?php

namespace App\Http\Controllers\Admin\ExhibitCollect;
use App\Http\Controllers\Admin\BaseAdminController;

class ExhibitController extends BaseAdminController
{

    /**
     * 征集申请web页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function apply(){
        $item1['num'] = 'ZJS2018...';
        $item1['depart_name'] = '关于三星...';
        $item1['depart_object'] = '三星他拉玉龙';
        $item1['depart_project_name'] = '三星他拉玉龙...';
        $item1['apply_depart'] = '展陈部';
        $item1['apply_money'] = '20万';
        $item1['apply_count'] = '1';
        $item1['applyer'] = '李海勇';
        $item1['project_desc'] = '收集该藏品是为了...';
        $item1['project_reason'] = '收集该藏品是为了...';

        $item2['num'] = 'ZJS2018...';
        $item2['depart_name'] = '关于司母...';
        $item2['depart_object'] = '后母戍鼎';
        $item2['depart_project_name'] = '后母...';
        $item2['apply_depart'] = '展陈部';
        $item2['apply_money'] = '11万';
        $item2['apply_count'] = '1';
        $item2['applyer'] = '李海勇';
        $item2['project_desc'] = '收集该藏品是为了...';
        $item2['project_reason'] = '收集该藏品是为了...';

        $res['exhibit_list'] = array($item1,$item2);
        return view('admin.exhibitcollect.apply', $res);
    }

    /**
     * 新增征集申请
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        return view('admin.exhibitcollect.add');
    }

    /**
     * 申请保存信息
     */
    public function apply_save(){
        return $this->success( get_session_url('apply'),'保存成功');
    }

    public function getin(){
        $item['num'] ='RG20180326';
        $item['name'] ='子龙铜棺';
        $item['date'] ='20180326';
        $item['recipe_num'] ='0003';
        $item['mark'] ='暂无备注';
        $item1['num'] ='RG20180326';
        $item1['name'] ='祺皇贵太妃';
        $item1['date'] ='20180327';
        $item1['recipe_num'] ='0001';
        $item1['mark'] ='暂无备注';
        $res['exhibit_list'] = array($item, $item1);
        return view('admin.exhibitcollect.getin',$res);
    }

    public function getin_add(){
        $res['exhibit_list'] = array();
        return view('admin.exhibitcollect.getin_add', $res);
    }

    public function getin_save(){
        return $this->success( get_session_url('getin'), '保存成功');
    }
}
