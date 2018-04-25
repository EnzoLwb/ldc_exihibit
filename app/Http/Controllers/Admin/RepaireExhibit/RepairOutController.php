<?php

namespace App\Http\Controllers\Admin\RepaireExhibit;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\RepairOutPost;
use App\Models\Exhibit;
use App\Models\ExhibitRepair\OutsideRepair;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class ApplyController
 *
 * @author lxp
 * @package App\Http\Controllers\Admin\Setting
 */
class RepairOutController extends BaseAdminController
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

		$outside_repair=new OutsideRepair();
		//搜索项 搜索藏品名称
		if (!empty( $request->exhibit_name)){
			$data=$outside_repair->where('name','like',"%{$request->exhibit_name}%")->latest()->paginate(parent::PERPAGE);
		}else{
			$data=$outside_repair->latest()->paginate(parent::PERPAGE);
		}
		return view('admin.repaireexhibit.repairout', [
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
		return view('admin.repaireexhibit.repairout_form');
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
		$data=OutsideRepair::find($id);
		//返回藏品名称和id
		$res=Exhibit::select('exhibit_sum_register_id as exhibit_id','name')->get()->toArray();
		return view('admin.repaireexhibit.repairout_form', [
			'data' => $data,'exhibit'=>$res
		]);
	}

	/**
	 * save
	 *
	 * @author lxp
	 * @param RepairOutPost $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function save(RepairOutPost $request)
	{
		try {
			$inside = OutsideRepair::find($request->outside_repair_id);
			if(!$inside){
				$inside=new OutsideRepair();
				$inside::create($request->all());
			}else{
				$inside->update($request->except('outside_repair_id','_token'));
			}
		} catch (\Exception $e) {
			//写入日志 保存失败
			report($e);
			return $this->error('保存失败');
		}
		return $this->success(route('admin.repaireexhibit.repairout'),'成功');
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
			if (OutsideRepair::destroy($id)){
				return $this->success(route('admin.repaireexhibit.repairout'),'成功');
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
		$repair_outside=new OutsideRepair();
		//选中的所有数据
		$res = $repair_outside->whereIn("outside_repair_id", $apply_ids)->get()->toArray();
		$xls_data = array();
		$header = ['藏品名称','修复前图片','修复中图片','修复后图片','申请状态','残损情况','修复要求','时间','修复数量','估价'];
		$xls_data[] = $header;
		foreach($res as $k=> $v)
		{
			$xls_data[] = array(
				$v['name'],
				$v['before_pic']==''?'暂无图片':$_SERVER['SERVER_NAME'].$v['before_pic'],
				$v['repairing_pic']==''?'暂无图片':$_SERVER['SERVER_NAME'].$v['repairing_pic'],
				$v['after_pic']==''?'暂无图片':$_SERVER['SERVER_NAME'].$v['after_pic'],
				$repair_outside->applyStatus($v['apply_status']),
				$v['incomplete_status'],
				$v['repair_require'],
				$v['date'],
				$v['repair_num'],
				$v['plan_price'],
			);
		}
		Excel::create('外修文物管理', function ($excel) use ($xls_data) {
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
		$repair_ids = $request->outside_repair_id;
		if(!empty($repair_ids) && is_array($repair_ids)){
			//选取未提交过的申请 提交
			OutsideRepair::where('apply_status','0')->whereIn('outside_repair_id',$repair_ids)->update(array('apply_status'=>'1'));
		}else{
			return $this->error('申请失败');
		}
		return $this->success('','已经提交申请');
	}
}