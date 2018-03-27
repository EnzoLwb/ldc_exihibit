<?php

namespace App\Http\Controllers\Admin\ExhibitIdentify;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseAdminController;

class ExhibitController extends BaseAdminController
{
    public function apply(){
        $item['date'] = '2018-01-26';
        $item['depart_name'] = '祺皇贵太妃之...';
        $item['identify_date'] = '2018-03-26';
        $item['identify_author'] = '里拉';
        $item['identify_danwei'] = 'A单位';
        $item['status'] = '审核通过';
        $item['author'] = '系统管理员';
        $res['exhibit_list'] = array($item);
        return view('admin.exhibitidentify.apply', $res);
    }

    public function add_identify_result(){
        return view('admin.exhibitidentify.add_identify_result');
    }

    public function add(){
        return view('admin.exhibitidentify.add');
    }

    /**
     * 鉴定管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage(){
        $item['date'] = '2018-01-26';
        $item['depart_name'] = '祺皇贵太妃之...';
        $item['identify_date'] = '2018-03-26';
        $item['identify_author'] = '里拉';
        $item['identify_danwei'] = 'A单位';
        $item['status'] = '审核通过';
        $item['author'] = '系统管理员';
        $res['exhibit_list'] = array($item);
        return view('admin.exhibitidentify.manage', $res);
    }

    /**
     * 鉴定专家管理
     */
    public function expert(){
        $item['name'] = '里拉';
        $item['sex'] = '男';
        $item['status'] = '已启用';
        $item['job'] = '主任';
        $item['rank'] = '专家';
        $item['depart'] = '文物部门';
        $item['depart'] = '文物部门';
        $item['result'] = '结果如下...';
        $item['goodat'] = '文物鉴定';
        $item['phone'] = '84849847';
        $res['exhibit_list'] = array($item);
        return view('admin.exhibitidentify.expert', $res);
    }

    /**
     * 新增鉴定专家
     */
    public function expert_add(){
        return view('admin.exhibitidentify.expert_add');
    }
}
