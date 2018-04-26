<?php

namespace App\Http\Controllers\Admin\ExhibitManage;

use App\Models\Exhibit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Accident;
use Illuminate\Support\Facades\Auth;
use App\Dao\ConstDao;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class AccidentRegistrationController extends BaseAdminController
{
    public function index(){
        $list = Accident::join('exhibit','accident.exhibit_sum_register_id','=','exhibit.exhibit_sum_register_id')
            ->select('accident_id','name','exhibit_sum_register_num','accident_time','accident_maker','accident_desc','proc_dependy'
            ,'proc_suggestion','accident.status')->where('accident.type', ConstDao::ACCOUNT_SUM)->get()->toArray();
        $list_2 = Accident::join('subsidiary','accident.exhibit_sum_register_id','=','subsidiary.subsidiary_id')
            ->select('accident_id','name','exhibit_sum_register_num','accident_time','accident_maker','accident_desc','proc_dependy'
                ,'proc_suggestion','accident.status')->where('accident.type', ConstDao::ACCOUNT_SUB)->get()->toArray();
        $list = array_merge($list_2, $list);
        $total = count($list); //记录总条数
        $perPage =parent::PERPAGE; //每页的记录数 ( 常量 )
        $current_page = \request('page',1); // 当前页
        $path = Paginator::resolveCurrentPath(); // 获取当前的链接"http://localhost/admin/account"
        $list = array_slice($list, ($current_page-1)*$perPage,$perPage);
        $infoList['paginator'] = new LengthAwarePaginator($list, $total,$perPage, $current_page, [
            'path' => $path ,  //设定个要分页的url地址。也可以手动通过 $paginator ->setPath(‘路径’) 设置
            'pageName' => 'page', //链接的参数名 http://localhost/admin/manage?page=2
        ]);
        $res['exhibit_list'] = $list;
        $res['paginator'] = $infoList['paginator'];
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
        $accident_model->type = \request('type');
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
        $count = Accident::whereIn('accident_id', $accident_ids)->where('status', '!=', ConstDao::ACCIDENT_STATUS_DRAFT)->count();
        if($count > 0){
            return response_json(0,array(),'包含已审核的内容');
        }
        Accident::whereIn('accident_id', $accident_ids)->update(array('status'=>ConstDao::ACCIDENT_STATUS_WAITING_AUDIT));
        return response_json(1,array(),'成功提交');
    }


    public function accident_del(){
        $accident_id = \request('accident_id');
        Accident::where('accident_id', $accident_id)->delete();
        return response_json(1,array(),'成功删除');
    }
}
