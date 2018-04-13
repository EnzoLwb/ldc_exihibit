<?php

namespace App\Http\Controllers\Admin\Statics;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\ExhibitRepair\InsideRepair;
use App\Models\ExhibitRepair\OutsideRepair;
use App\Models\ExhibitRepair\RepairApply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;

class RepaireController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		//默认展示最近7年 如果用户填写时间 就按填写的时间计算
		$start_year='2012';
		$end_year='2019';
		$year=$normal=$repair_apply=$inside=$outside=[];
		//横坐标 以年份为主   纵坐标就是 修复数
		if (!empty($request->start_year)){
			$start_year=date("Y", strtotime($request->start_year));
		}
		if (!empty($request->end_year)){
			$end_year=date("Y", strtotime($request->end_year));
		}
		for($i=0;$i<=$end_year-$start_year;$i++){
			$year[]=$start_year+$i;
		}
		//对应年份的文物数量
		foreach ($year as $v){
			//普通修复申请的数量统计

			$normal=RepairApply::where('apply_status',2)->whereRaw('DATE_FORMAT(updated_at,"%Y")=?', $v)
				->selectRaw("sum(length(exhibit_sum_register_id)-length(replace(exhibit_sum_register_id,',',''))) as cou")->get()->toArray();
			$repair_apply[]=$normal[0]['cou']==null?0:(Integer)$normal[0]['cou'];
			//内修复申请的数量统计
			$inside[]=InsideRepair::where('apply_status',2)->whereRaw('DATE_FORMAT(updated_at,"%Y")=?', $v)->count();
			//外修复申请的数量统计
			$outside[]=OutsideRepair::where('apply_status',2)->whereRaw('DATE_FORMAT(updated_at,"%Y")=?', $v)->count();
		}

		$res['chart_x'] = json_encode($year);
        $res['data_inside'] = json_encode($inside);
        $res['data_outside'] = json_encode($outside);
        $res['data_repair_apply'] = json_encode($repair_apply);
//        dd($res);
        return view('admin.statics.repair', $res);
	}
}