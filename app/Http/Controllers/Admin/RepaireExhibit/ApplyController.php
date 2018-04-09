<?php

namespace App\Http\Controllers\Admin\RepaireExhibit;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\ExhibitRepair\RepairApply;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class ApplyController
 *
 * @author lxp
 * @package App\Http\Controllers\Admin\Setting
 */
class ApplyController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * index
	 *
	 * @author lxp
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$repairApply=new RepairApply();
		//搜索项 搜索藏品名称
		if (!empty( $request->repair_order_no)){
			$data=$repairApply->where('repair_order_no','like',"%{$request->repair_order_no}%")->paginate(parent::PERPAGE);
		}else{
			$data=$repairApply->paginate(parent::PERPAGE);
		}
		return view('admin.repaireexhibit.apply', [
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
		return view('admin.repaireexhibit.apply_form');
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
		$detail=RepairApply::find($id);
		return view('admin.repaireexhibit.apply_form', [
			'data' => $detail
		]);
	}

	/**
	 * save
	 *
	 * @author lxp
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function save(Request $request)
	{
		// 验证
		$this->validate($request, [
			'repair_order_no'=>'required',
			'repair_order_name'=>'required',
			'register_date'=>'required|date',
		],[
			'required'=>':attribute 为必填项',
			'date'=>':attribute 填写规范日期格式',
		],[
			'repair_order_no'=>'修复申请单号',
			'repair_order_name'=>'修复申请单名称',
			'register_date'=>'登记日期',
		]);

		try {
			$repair = RepairApply::find($request->repair_id);
			if(!$repair){
				$repair=new RepairApply();
				$repair::create($request->all());
			}else{
				$repair->update($request->except('repair_id','_token'));
			}
		} catch (\Exception $e) {
			//写入日志 保存失败
			report($e);
			return $this->error('保存失败');
		}
		// 保存数据
		return $this->success(route('admin.repaireexhibit.apply'),'成功');
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
			if (RepairApply::destroy($id)){
				return $this->success(route('admin.repaireexhibit.apply'),'成功');
			}
		} catch (\Exception $e) {
			//写入日志 保存失败
			report($e);
		}
		return $this->error('删除失败');
	}
	/**
	 * 导出excel
	 */
	public function excel()
	{
		$apply_ids = request('apply_ids');
		$repairApply=new RepairApply();
		//选中的所有数据
		$res = $repairApply->whereIn("repair_id", $apply_ids)->get()->toArray();
		$xls_data = array();
		$header = ['修复申请单号','修复申请单名称','经费预算','状态','登记人','登记日期'];
		$xls_data[] = $header;
		foreach($res as $k=> $v)
		{
			//			unset($res[$k]['files']); 删除附件之类的数据
			$xls_data[] = array(
				$v['repair_order_no'],
				$v['repair_order_name'],
				$v['plan_expense'],
				$repairApply->applyStatus($v['apply_status']),
				$v['register_member'],
				$v['register_date']
			);
		}
		Excel::create('藏品修复', function ($excel) use ($xls_data) {
			$excel->sheet('score', function ($sheet) use ($xls_data) {
				$sheet->setWidth(array(
					'A'     => 20,
					'B'     =>  25,
					'C'     =>  25,
					'D'     =>  25,
					'E'     =>  25,
					'F'     =>  25,
					'G'     =>  25,
				));
				$sheet->rows($xls_data);
			});
		})->export('xls');

	}
	/**
	 * 提交申请
	 */
	public function apply_submit(Request $request)
	{
		$repair_ids = $request->repair_ids;
		if(!empty($repair_ids) && is_array($repair_ids)){
			//选取未提交过的申请 提交
			RepairApply::where('apply_status','0')->whereIn('repair_id',$repair_ids)->update(array('apply_status'=>'1'));
		}
		return $this->success('','已经提交申请');
	}
}