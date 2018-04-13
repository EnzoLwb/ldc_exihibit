<?php

namespace App\Http\Controllers\Admin\Statics;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\ExhibitRepair\InsideRepair;
use App\Models\ExhibitRepair\OutsideRepair;
use Illuminate\Support\Facades\DB;

class RepaireController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        //横坐标 以年份为主   纵坐标就是 修复数
		//获取两表的所有年份
		$year=DB::select("SELECT DISTINCT (DATE_FORMAT(updated_at,'%Y')) as year from ".env('DB_PREFIX')."inside_repair where apply_status=2 union 
SELECT DISTINCT (DATE_FORMAT(updated_at,'%Y')) as year from ".env('DB_PREFIX')."outside_repair where apply_status=2");
		foreach ($year as $value){
			$y[]=$value->year;//将对象变成数组
		}
		//对应年份的文物数量
		foreach ($y as $v){
			$inside[]=InsideRepair::where('apply_status',2)->whereRaw('DATE_FORMAT(updated_at,"%Y")=?', $v)->count();
			$outside[]=OutsideRepair::where('apply_status',2)->whereRaw('DATE_FORMAT(updated_at,"%Y")=?', $v)->count();
		}
		$res['chart_x'] = json_encode($y);
        $res['data_inside'] = json_encode($inside);
        $res['data_outside'] = json_encode($outside);
        return view('admin.statics.repair', $res);
	}
}