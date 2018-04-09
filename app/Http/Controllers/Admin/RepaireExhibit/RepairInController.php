<?php

namespace App\Http\Controllers\Admin\RepaireExhibit;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\RepairinPost;
use App\Models\Exhibit;
use App\Models\ExhibitRepair\InsideRepair;
use Illuminate\Http\Request;

/**
 * Class ApplyController
 *
 * @author lxp
 * @package App\Http\Controllers\Admin\Setting
 */
class RepairInController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 内修文物管理
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$inside_repair=new InsideRepair();
		//搜索项 搜索藏品名称
		if (!empty( $request->repair_order_name)){
			$data=$inside_repair->where('repair_order_name','like',"%{$request->repair_order_name}%")->paginate(parent::PERPAGE);
		}else{
			$data=$inside_repair->paginate(parent::PERPAGE);
		}
        return view('admin.repaireexhibit.repairin', [
			'data' => $data
		]);
	}
	/**
	 * 查看内修文物详情
	 * @author lwb 20180409
	 */
	public function detail($id)
	{
		$data=InsideRepair::find($id);
		return view('admin.repaireexhibit.repairin_detail', [
			'data' => $data
		]);
	}
	/**
	 * add
	 *
	 * @author lxp
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{
		//返回藏品名称和id
		$res=Exhibit::select('exhibit_sum_register_id as exhibit_id','name')->get()->toArray();
		return view('admin.repaireexhibit.repairin_form',['exhibit'=>$res]);
	}
	/**
	 * 藏品详情查询
	 * @author lwb 20180408
	 * @return json
	 */
	public function exhibit_detail(Request $request)
	{
		$res=Exhibit::find($request->exhibit_id);
		$data=['size'=>$res->size,'weight'=>$res->quality,'type_no'=>$res->type_num,'age'=>$res->age,'level'=>$res->exhibit_level,'quality'=>$res->textaure1];
		return response()->json($data);
	}
	/**
	 * edit
	 *
	 * @author lxp
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($id)
	{
		$data=InsideRepair::find($id);
		//返回藏品名称和id
		$res=Exhibit::select('exhibit_sum_register_id as exhibit_id','name')->get()->toArray();
		return view('admin.repaireexhibit.repairin_form', [
			'data' => $data,'exhibit'=>$res
		]);
	}

	/**
	 * save
	 *
	 * @author lwb
	 * @param RepairinPost $request 表单验证
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function save(RepairinPost $request)
	{
		// 保存数据
		try {
			$inside = InsideRepair::find($request->inside_repair_id);
			if(!$inside){
				$inside=new InsideRepair();
				$inside::create($request->all());
			}else{
				$inside->update($request->except('inside_repair_id','_token'));
			}
		} catch (\Exception $e) {
			//写入日志 保存失败
			report($e);
			return $this->error('保存失败');
		}
		return $this->success(route('admin.repaireexhibit.repairin'),'成功');

	}

	/**
	 * delete
	 *
	 * @author lxp
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function delete($id)
	{
		// 删除
		try {
			if (InsideRepair::destroy($id)){
				return $this->success(route('admin.repaireexhibit.repairin'),'成功');
			}
		} catch (\Exception $e) {
			//写入日志 保存失败
			report($e);
		}
		return $this->error('删除失败');
	}
}