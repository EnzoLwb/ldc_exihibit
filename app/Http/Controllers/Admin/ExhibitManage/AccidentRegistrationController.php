<?php

namespace App\Http\Controllers\Admin\ExhibitManage;

use App\Models\Exhibit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Accident;
use Illuminate\Support\Facades\Auth;
use App\Dao\ConstDao;

class AccidentRegistrationController extends BaseAdminController
{
    public function index(){
        $res['exhibit_list'] = Accident::join('exhibit','accident.exhibit_sum_register_id','=','exhibit.exhibit_sum_register_id')
            ->select('accident_id','name','exhibit_sum_register_num','accident_time','accident_maker','accident_desc','proc_dependy'
            ,'proc_suggestion','accident.status')->get();
        return view('admin.exhibitmanage.accidentregistration_list', $res);
    }

    /**
     * 增加事故登记
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_accidentregistration(){
        $res['info'] = Accident::findOrnew(\request('accident_id'));
        $res['exhibit_list'] = Exhibit::select('exhibit_sum_register_id','name')->get();
        return view('admin.exhibitmanage.add_accidentregistration', $res);
    }

    /**
     * 保存事故信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function accidentregistration_save(){
        $accident_id = \request('accident_id');
        $accident_model = Accident::findOrNew($accident_id);
        $exhibit_sum_register_id= \request('exhibit_sum_register_id');
        $accident_model->exhibit_sum_register_id = $exhibit_sum_register_id;
        if(empty($exhibit_sum_register_id)){
            return $this->error('参数有误');
        }
        $accident_model->accident_time = \request('accident_time');
        $accident_model->accident_maker = \request('accident_maker');
        $accident_model->accident_desc = \request('accident_desc');
        $accident_model->proc_dependy = \request('proc_dependy');
        $accident_model->proc_suggestion = \request('proc_suggestion');
        $accident_model->recorder = Auth::user()->username;
        $accident_model->status = ConstDao::ACCIDENT_STATUS_DRAFT;
        $accident_model->save();
        return $this->success('accidentregistration','保存成功');
    }


    /**
     * 提交审核
     * @return \Illuminate\Http\JsonResponse
     */
    public function accidentregistration_submit(){
        $accident_ids = \request('accident_id');
        if(empty($accident_ids)){
            return response_json(0,array(),'参数错误');
        }
        Accident::whereIn('accident_id', $accident_ids)->update(array('status'=>ConstDao::ACCIDENT_STATUS_WAITING_AUDIT));
        return response_json(1,array(),'成功提交');
    }
}
