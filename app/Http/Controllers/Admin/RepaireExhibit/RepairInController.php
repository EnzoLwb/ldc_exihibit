<?php

namespace App\Http\Controllers\Admin\RepaireExhibit;

use App\Dao\ConstDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\RepairinPost;
use App\Models\Exhibit;
use App\Models\ExhibitRepair\InsideRepair;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
		if ($request->account_type==ConstDao::ACCOUNT_SUM){
			//总账类型
			$res=Exhibit::find($request->exhibit_id);
			$data=['size'=>$res->size,'weight'=>$res->quality,'type_no'=>$res->type_num,'age'=>$res->age,'level'=>$res->exhibit_level,'quality'=>$res->textaure1];
		}elseif ($request->account_type==ConstDao::ACCOUNT_SUB){
			//辅助账
			$res=Subsidiary::find($request->exhibit_id);
			$data=['size'=>'','weight'=>'','type_no'=>$res->type_num,'age'=>$res->age,'level'=>'','quality'=>$res->textaure1];
		}
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
	/**
	 * 导出excel
	 */
	public function excel()
	{
		$apply_ids = request('apply_ids');
		$repair_inside=new InsideRepair();
		//选中的所有数据
		$res = $repair_inside->whereIn("inside_repair_id", $apply_ids)->get()->toArray();
		$xls_data = array();
		$header = ['档案号','藏品名称','修复前图片','修复中图片','修复后图片','申请状态','提取日期','归还时间','主持人','修复人','文物现状'];
		$xls_data[] = $header;
		foreach($res as $k=> $v)
		{
			//			unset($res[$k]['files']); 删除附件之类的数据
			$xls_data[] = array(
				$v['repair_order_name'],
				$v['name'],
				$v['before_pic']==''?'暂无图片':$_SERVER['SERVER_NAME'].$v['before_pic'],
				$v['repairing_pic']==''?'暂无图片':$_SERVER['SERVER_NAME'].$v['repairing_pic'],
				$v['after_pic']==''?'暂无图片':$_SERVER['SERVER_NAME'].$v['after_pic'],
				$repair_inside->applyStatus($v['apply_status']),
				$v['pickup_date'],
				$v['return_date'],
				$v['host'],
				$v['restorer'],
				$v['exhibit_status'],
			);
		}
		Excel::create('内修文物管理', function ($excel) use ($xls_data) {
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
		$repair_ids = $request->inside_repair_id;
		if(!empty($repair_ids) && is_array($repair_ids)){
			//选取未提交过的申请 提交
			InsideRepair::where('apply_status','0')->whereIn('inside_repair_id',$repair_ids)->update(array('apply_status'=>'1'));
		}else{
			return $this->error('申请失败');
		}
		return $this->success('','已经提交申请');
	}
}