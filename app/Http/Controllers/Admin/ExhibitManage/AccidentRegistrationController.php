<?php

namespace App\Http\Controllers\Admin\ExhibitManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseAdminController;

class AccidentRegistrationController extends BaseAdminController
{
    public function index(){
        $res['exhibit_list'] = array();
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
