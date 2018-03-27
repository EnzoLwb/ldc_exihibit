<?php

namespace App\Http\Controllers\Admin\ExhibitIdentify;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseAdminController;

class ExhibitController extends BaseAdminController
{
    public function apply(){
        $res['exhibit_list'] = array();
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
        $res['exhibit_list'] = array();
        return view('admin.exhibitidentify.manage', $res);
    }

    /**
     * 鉴定专家管理
     */
    public function expert(){
        $res['exhibit_list'] = array();
        return view('admin.exhibitidentify.expert', $res);
    }

    /**
     * 新增鉴定专家
     */
    public function expert_add(){
        return view('admin.exhibitidentify.expert_add');
    }
}
