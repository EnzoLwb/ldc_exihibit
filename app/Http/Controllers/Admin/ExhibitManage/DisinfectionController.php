<?php

namespace App\Http\Controllers\Admin\ExhibitManage;

use App\Dao\ConstDao;
use App\Models\Disinfection;
use App\Models\Exhibit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class DisinfectionController extends BaseAdminController
{

    /**
     * 消毒登记列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function index(){
        $title = \request('title');
        if(empty($title)){
            // 文物信息
            $list = Disinfection::join('exhibit','disinfection.exhibit_sum_register_id','=','exhibit.exhibit_sum_register_id')
                ->select('name', DB::Raw('ldc_disinfection.exhibit_sum_register_id'), 'disinfection_way', 'clean_date',DB::Raw('ldc_disinfection.disinfection_id'),
                    'exhibit_sum_register_num','clean_way')
                ->where('disinfection.type', ConstDao::ACCOUNT_SUM)
                ->orderBy('clean_date','desc')->get()->toArray();
            // 辅助文物信息
            $list_2 = Disinfection::join('subsidiary','disinfection.exhibit_sum_register_id','=','subsidiary.subsidiary_id')
                ->select('name', DB::Raw('ldc_disinfection.exhibit_sum_register_id'), 'disinfection_way', 'clean_date',DB::Raw('ldc_disinfection.disinfection_id'),
                    'exhibit_sum_register_num','clean_way')
                ->where('disinfection.type', ConstDao::ACCOUNT_SUB)
                ->orderBy('clean_date','desc')->get()->toArray();
            $list = array_merge($list, $list_2);
        }else{
            //文物信息
            $list = Disinfection::join('exhibit','disinfection.exhibit_sum_register_id','=','exhibit.exhibit_sum_register_id')
                ->select('name', DB::Raw('ldc_disinfection.exhibit_sum_register_id'), 'disinfection_way', 'clean_date', DB::Raw('ldc_disinfection.disinfection_id'),
                    'exhibit_sum_register_num', 'clean_way')
                ->where('disinfection.type', ConstDao::ACCOUNT_SUM)
                ->where('name','like','%'.$title."%")->orderBy('clean_date','desc')->get()->toArray();
            //辅助文物信息
            $list_2 = Disinfection::join('subsidiary','disinfection.exhibit_sum_register_id','=','subsidiary.subsidiary_id')
                ->select('name', DB::Raw('ldc_disinfection.exhibit_sum_register_id'), 'disinfection_way', 'clean_date',DB::Raw('ldc_disinfection.disinfection_id'),
                    'exhibit_sum_register_num','clean_way')
                ->where('disinfection.type', ConstDao::ACCOUNT_SUB)->where('name','like','%'.$title."%")
                ->orderBy('clean_date','desc')->get()->toArray();
            $list = array_merge($list, $list_2);
        }
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
        $disinfection_model->type = \request('type');
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