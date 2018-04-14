<?php

namespace App\Http\Controllers\Admin\DigitalSearch;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\ExhibitRepair\InsideRepair;
use App\Models\ExhibitRepair\OutsideRepair;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RepairController extends BaseAdminController
{
	/**
	 * 修复藏品的总和查询
	 * @author
	 */
	//内修复藏品统计
	public function index(Request $request){
		$inside_repair=new InsideRepair();
		$data=$inside_repair->exhibitDetail()->where('apply_status','2');
		//搜索项 搜索档案号
		if (!empty( $request->repair_order_name)){
			$data->where('repair_order_name','like',"%{$request->repair_order_name}%");
		}
		//搜索藏品名称
		if (!empty( $request->name)){
			$data->where('exhibit.name','like',"%{$request->name}%");
		}
		//搜索藏品分类号
		if (!empty( $request->type_num)){
			$data->where('exhibit.type_num','like',"%{$request->type_num}%");
		}
		//藏品年代
		if (!empty( $request->age)){
			$data->where('exhibit.age','like',"%{$request->age}%");
		}
		//主持人
		if (!empty( $request->host)){
			$data->where('host','like',"%{$request->host}%");
		}
		//修复人
		if (!empty( $request->restorer)){
			$data->where('restorer','like',"%{$request->restorer}%");
		}
		//提取时间
		if(!empty($request->pickup_date)){
			$data->whereRaw('DATE_FORMAT(pickup_date,"%Y-%m-%d")=?', $request->pickup_date);
		}
		//归还时间
		if(!empty($request->return_date)){
			$data->whereRaw('DATE_FORMAT(return_date,"%Y-%m-%d")=?', $request->return_date);
		}
		return view('admin.digitalsearch.repair.list', [
			'exhibit_list' => $data->paginate(parent::PERPAGE)
		]);
	}

	//外修复藏品统计
	public function repairout(Request $request){
		$inside_repair=new OutsideRepair();
		$data=$inside_repair->exhibitDetail()->where('apply_status','2');
		//搜索藏品名称
		if (!empty( $request->name)){
			$data->where('exhibit.name','like',"%{$request->name}%");
		}
		//搜索藏品分类号
		if (!empty( $request->type_num)){
			$data->where('exhibit.type_num','like',"%{$request->type_num}%");
		}
		//藏品年代
		if (!empty( $request->age)){
			$data->where('exhibit.age','like',"%{$request->age}%");
		}
		//归还时间
		if(!empty($request->date)){
			$data->whereRaw('DATE_FORMAT(date,"%Y-%m-%d")=?', $request->date);
		}
		return view('admin.digitalsearch.repair.repairout', [
			'exhibit_list' => $data->paginate(parent::PERPAGE)
		]);
	}
}
