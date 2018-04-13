<?php

namespace App\Http\Controllers\Admin\Statics;

use App\Dao\ExchibitDao;
use App\Dao\ExpertDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\IdentifyResult;

class IdentifyController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

    /**
     * 鉴定统计
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function index()
	{
        $year_count = 6;//默认展示最近7年
        $expert_id = request('expert_id');
        $type = request('type');
        $textaure = request('quality');
        $start_year = request('start_year',date("Y-01-01 00:00:00", strtotime('-'.$year_count.' year')));
        $start_year = date("Y-01-01 00:00:00", strtotime($start_year));
        $real_end_year = request('end_year',date("Y-01-01 00:00:00", strtotime('+1 year')));
        $res_raw = [];
        while($start_year<=$real_end_year){
            $item = array();
            $end_year = date("Y-01-01 00:00:00", strtotime("$start_year+1year"));
            $item['year'] = date("Y", strtotime($start_year));

            $query = IdentifyResult::where('created_at',">=", $start_year)->where('created_at','<=', $end_year);
            if(!empty($expert_id)){
                $query = $query->where('identify_maker', $expert_id);
            }
            if(!empty($textaure)){
                $query = $query->where('quality', 'like', '%'.$textaure.'%');
            }
            if(!empty($type)){
                $query = $query->where('type', 'like', '%'.$type.'%');
            }
            $item['num'] = $query->count();
            $res_raw[] = $item;
            $start_year = date("Y-01-01 00:00:00", strtotime("$start_year+1year"));
        }
        $res = array('chart_x'=>array(), 'add'=>[],'minus'=>[]);
        foreach($res_raw as $item1){
            $res['chart_x'][] = $item1['year'];
        }
        $res['chart_x'] = \json_encode($res['chart_x']);
        foreach($res_raw as $item2){
            $res['num'][] = $item2['num'];
        }
        $res['num'] = \json_encode($res['num']);
	    $res['expert_list'] = ExpertDao::get_expert_list();
	    return view('admin.statics.identify', $res);
	}
}