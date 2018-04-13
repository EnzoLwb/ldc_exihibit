<?php

namespace App\Http\Controllers\Admin\Statics;

use App\Dao\ConstDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Exhibit;

class ExhibitController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

    /**
     * 藏品增減统计
     */
	public function index()
	{
        $year_count = 6;//默认展示最近7年
	    $start_year = request('start_year',date("Y-01-01 00:00:00", strtotime('-'.$year_count.' year')));
        $start_year = date("Y-01-01 00:00:00", strtotime($start_year));
        $real_end_year = request('end_year',date("Y-01-01 00:00:00", strtotime('+1 year')));
        $res_raw = [];
        while($start_year<=$real_end_year){
            $item = array();
            $end_year = date("Y-01-01 00:00:00", strtotime("$start_year+1year"));
            $item['year'] = date("Y", strtotime($start_year));
            $item['add'] = Exhibit::where('created_at', '>=', $start_year)->where('created_at','<=', $end_year)->count();
            $item['minus'] = Exhibit::where('updated_at',">=", $start_year)->where('updated_at',"<=", $end_year)
                ->whereIn('status', array(ConstDao::EXHIBIT_STATUS_BOJIAO, ConstDao::EXHIBIT_STATUS_LOGOUT))->count();
            $res_raw[] = $item;
            $start_year = date("Y-01-01 00:00:00", strtotime("$start_year+1year"));
        }
        $res = array('chart_x'=>array(), 'add'=>[],'minus'=>[]);
        foreach($res_raw as $item1){
            $res['chart_x'][] = $item1['year'];
        }
        $res['chart_x'] = \json_encode($res['chart_x']);
        foreach($res_raw as $item2){
            $res['add'][] = $item2['add'];
        }
        $res['add'] = \json_encode($res['add']);
        foreach($res_raw as $item3){
            $res['minus'][] = $item3['minus'];
        }
        $res['minus'] = \json_encode($res['minus']);
        return view('admin.statics.exhibit', $res);
	}

    /**
     * 藏品来源统计
     */
	public function src(){
	    //默认七年
        $src = request('src');
        $start_year = date("Y-01-01 00:00:00", time()-6*(365*24*3600));
        $end_year = date("Y-01-01 00:00:00", time()+365*24*3600);
        $res['num'] = [];
        $res['chart_x'] = [];
        while($start_year< $end_year){
            $current_end_year = date("Y-01-01 00:00:00", strtotime("$start_year+1year"));
            if(!empty($src)){
                $count = Exhibit::where('created_at','>=', $start_year)->where('created_at','<=', $current_end_year)
                    ->where('src','like','%'.$src.'%')->count();
            }else{
                $count = Exhibit::where('created_at','>=', $start_year)->where('created_at','<=', $current_end_year)->count();
            }

            $start_year = $current_end_year;
            $res['chart_x'][] = date("Y", strtotime($start_year));
            $res['num'][] = $count;
        }
        $res['num'] = \json_encode($res['num']);
        $res['chart_x'] = \json_encode($res['chart_x']);
        return view('admin.statics.exhibit_src', $res);
    }

    /**
     * 藏品状态统计
     */
    public function status_func(){
        //默认六年
        $status = request('status');
        $start_year = date("Y-01-01 00:00:00", time()-6*(365*24*3600));
        $end_year = date("Y-01-01 00:00:00", time()+365*24*3600);
        $res['num'] = [];
        $res['chart_x'] = [];
        while($start_year< $end_year){
            $current_end_year = date("Y-01-01 00:00:00", strtotime("$start_year+1year"));
            if(!empty($status)){
                $count = Exhibit::where('created_at','>=', $start_year)->where('created_at','<=', $current_end_year)
                    ->where('status',$status)->count();
            }else{
                $count = Exhibit::where('created_at','>=', $start_year)->where('created_at','<=', $current_end_year)
                    ->count();
            }

            $start_year = $current_end_year;
            $res['chart_x'][] = date("Y", strtotime($start_year));
            $res['num'][] = $count;
        }
        $res['num'] = \json_encode($res['num']);
        $res['chart_x'] = \json_encode($res['chart_x']);
        return view('admin.statics.exhibit_status', $res);
    }

    /**
     * 类型统计
     */
    public function type(){
        //默认六年
        $exhibit_level = request('exhibit_level');
        $type = request('type');
        $start_year = date("Y-01-01 00:00:00", time()-6*(365*24*3600));
        $end_year = date("Y-01-01 00:00:00", time()+365*24*3600);
        $res['num'] = [];
        $res['chart_x'] = [];
        while($start_year< $end_year){
            $current_end_year = date("Y-01-01 00:00:00", strtotime("$start_year+1year"));
            $query = Exhibit::where('created_at','>=', $start_year)->where('created_at','<=', $current_end_year);
            if(!empty($exhibit_level)){
                $query->where('exhibit_level', $exhibit_level);
            }
            if(!empty($type)){
                $query->where('type', '%'.$type."%");
            }
            $count = $query->count();
            $start_year = $current_end_year;
            $res['chart_x'][] = date("Y", strtotime($start_year));
            $res['num'][] = $count;
        }
        $res['num'] = \json_encode($res['num']);
        $res['chart_x'] = \json_encode($res['chart_x']);
        return view('admin.statics.exhibit_type', $res);
    }
}