<?php

namespace App\Http\Controllers\Admin\Statics;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Subsidiary;
use Illuminate\Support\Facades\DB;

class CopyController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		//横坐标 以年份为主   纵坐标就是 修复数
		//获取两表的所有年份
		$year=Subsidiary::where('apply_status',2)->GroupBy(DB::raw("DATE_FORMAT(updated_at,'%Y')"))->select(DB::raw("DATE_FORMAT(updated_at,'%Y') as year"))->get();
		foreach ($year as $value){
			$y[]=$value->year;//将对象变成数组
		}
		//对应年份的文物数量
		foreach ($y as $v){
			//复制品登记账
			$copy[]=Subsidiary::where(['apply_status'=>2,'type'=>'1'])->whereRaw('DATE_FORMAT(updated_at,"%Y")=?', $v)->count();
			//仿制品登记账
			$imitate[]=Subsidiary::where(['apply_status'=>2,'type'=>'2'])->whereRaw('DATE_FORMAT(updated_at,"%Y")=?', $v)->count();
		}
		$res['chart_x'] = json_encode($y);
		$res['data_copy'] = json_encode($copy);
		$res['data_imitate'] = json_encode($imitate);
		return view('admin.statics.copy', $res);
	}
}