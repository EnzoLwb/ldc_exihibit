<?php

namespace App\Http\Controllers\Admin\ExhibitManage;

use App\Dao\ConstDao;
use App\Models\Disinfection;
use App\Models\Exhibit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;

class DisinfectionController extends BaseAdminController
{

    /**
     * 消毒登记列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function index(){
        $title = \request('title');
        if(empty($title)){
            $res['exhibit_list'] = Disinfection::join('exhibit','disinfection.exhibit_sum_register_id','=','exhibit.exhibit_sum_register_id')
                ->orderBy('clean_date','desc')->paginate(parent::PERPAGE);
        }else{
            $res['exhibit_list'] = Disinfection::join('exhibit','disinfection.exhibit_sum_register_id','=','exhibit.exhibit_sum_register_id')
                ->where('name','like','%'.$title."%")->orderBy('clean_date','desc')->paginate(parent::PERPAGE);
        }
        return view('admin.exhibitmanage.disinfection_list', $res);
    }

    /**
     * 增加消毒记录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_disinfection(){
        $disinfection_id = \request('disinfection_id');
        if(empty($disinfection_id)){
            $exhibit_list = Exhibit::select('name', 'exhibit_sum_register_id')->paginate(parent::PERPAGE);
            $res['exhibit_list'] = $exhibit_list;
        }else{
            $info = Disinfection::findOrfail($disinfection_id);
            $res['info'] = $info;
        }
        return view('admin.exhibitmanage.add_disinfection', $res);
    }

    /**
     * 保存消毒记录相关信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public  function  disinfection_save(){
        $disinfection_id = \request('disinfection_id');
        $disinfection_model = Disinfection::findOrNew($disinfection_id);
        $exhibit_sum_register_id = \request('exhibit_sum_register_id');
        $exhibit_model = Exhibit::find($exhibit_sum_register_id);
        if(empty($exhibit_model)){
            return $this->error('参数有误');
        }
        $disinfection_model->exhibit_sum_register_id =$exhibit_sum_register_id;
        $disinfection_model->clean_date = \request('clean_date');
        $disinfection_model->disinfection_way = \request('disinfection_way');
        $disinfection_model->clean_way = \request('clean_way');
        $disinfection_model->recorder  = Auth::user()->username;
        $disinfection_model->save();
        return $this->success('disinfection','保存消毒记录');
    }

    /**
     * 删除消毒记录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function del_disinfection(){
        $disinfection_ids = \request('disinfection_id');
        Disinfection::whereIn('disinfection_id',$disinfection_ids)->delete();
        return $this->success('disinfection','操作成功');
    }
}