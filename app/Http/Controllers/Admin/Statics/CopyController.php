<?php

namespace App\Http\Controllers\Admin\Statics;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CopyController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		//横坐标 以年份为主   纵坐标就是 修复数
		//获取两表的所有年份
		//默认展示最近7年 如果用户填写时间 就按填写的时间计算
		$start_year='2012';
		$end_year='2019';
		$year=$copy=$imitate=[];
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
			//复制品登记账
			$copy[]=Subsidiary::where(['apply_status'=>2,'type'=>'1'])->whereRaw('DATE_FORMAT(updated_at,"%Y")=?', $v)->count();
			//仿制品登记账
			$imitate[]=Subsidiary::where(['apply_status'=>2,'type'=>'2'])->whereRaw('DATE_FORMAT(updated_at,"%Y")=?', $v)->count();
		}
		$res['chart_x'] = json_encode($year);
		$res['data_copy'] = json_encode($copy);
		$res['data_imitate'] = json_encode($imitate);
		return view('admin.statics.copy', $res);
	}
}