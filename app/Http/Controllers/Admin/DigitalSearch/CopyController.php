<?php

namespace App\Http\Controllers\Admin\DigitalSearch;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Exhibit;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 复仿制查询的控制器
 * Class CopyController
 * @package App\Http\Controllers\Admin\DigitalSearch
 */
class CopyController extends BaseAdminController
{

    /**
     * 复制品查询
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $range_type = \request('range_type');
        $name = \request('name');
        $created_at = \request('created_at');
        $query = Subsidiary::query();
        $query->where('type',1);
        if(!empty($range_type)){
            $query->where('range_type','like','%'.$range_type.'%');
        }
        if(!empty($name)){
            $query->where('name','like','%'.$name.'%');
        }
        //精确到月
        if(!empty($created_at)){
            $created_at = date("Y-m-01 00:00:00", strtotime($created_at));
            $created_at_end = date("Y-m-01 00:00:00", strtotime("$created_at+1month"));
            $query->where('created_at','>=',$created_at)->where('created_at','<=', $created_at_end);
        }
        $res['exhibit_list'] = $query->paginate(parent::PERPAGE);
        return view('admin.digitalsearch.copy.list',$res);
    }

    /**
     * 查看辅助账
     */
    public function view_subsidiary(){
        $subsidiary_id = \request('subsidiary_id');
        $info = Subsidiary::where('subsidiary_id', $subsidiary_id)->first();
        $res['data'] = $info;
        return view('admin.digitalsearch.copy.view_subsidiary', $res);
    }

    /**
     * 仿制品查询
     */
    public function copy_by(){
        $range_type = \request('range_type');
        $name = \request('name');
        $created_at = \request('created_at');
        $query = Subsidiary::query();
        $query->where('type',2);//仿制品查询
        if(!empty($range_type)){
            $query->where('range_type','like','%'.$range_type.'%');
        }
        if(!empty($name)){
            $query->where('name','like','%'.$name.'%');
        }
        //精确到月
        if(!empty($created_at)){
            $created_at = date("Y-m-01 00:00:00", strtotime($created_at));
            $created_at_end = date("Y-m-01 00:00:00", strtotime("$created_at+1month"));
            $query->where('created_at','>=',$created_at)->where('created_at','<=', $created_at_end);
        }
        $res['exhibit_list'] = $query->paginate(parent::PERPAGE);
        return view('admin.digitalsearch.copy.list_copy_by',$res);
    }
}
