<?php

namespace App\Http\Controllers\Admin\Storageroommanage;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\PeopleinoutManagePost;
use App\Models\Storageroommanage\PeopleinoutManage;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class PeopleInOutManageController
 * 人员出入管理
 * @author lwb 2018 0330
 * @package App\Http\Controllers\Admin\Storageroommanage
 */
class PeopleInOutManageController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 人员出入管理列表
	 *
	 * @author lwb 2018 0330
	 * @param  Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		//搜索项 搜索库房编号
		if (!empty( $request->storeroom_id)){
			$pio_data=PeopleinoutManage::where('storeroom_id','like',"%{$request->storeroom_id}%")->paginate(parent::PERPAGE);
		}else{
			$pio_data=PeopleinoutManage::paginate(parent::PERPAGE);
		}
		return view('admin.storageroommanage.peopleinoutmanage', [
			'data' => $pio_data
		]);
	}

	/**
	 * 新增
	 *
	 * @author lxp
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{
		return view('admin.storageroommanage.peopleinpout_form');
	}

	/**
	 * edit
	 *
	 * @author lwb
	 * @param $id 2018 0331
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($id)
	{
		$pio_detail=PeopleinoutManage::find($id);
		return view('admin.storageroommanage.peopleinpout_form', [
			'data' => $pio_detail
		]);
	}

	/**
	 * save
	 *
	 * @author lwb 2018 0331
	 * @param  PeopleinoutManagePost $request 人员出入管理的表单验证
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function save(PeopleinoutManagePost $request)
	{
		// 保存数据
		try {
			$pio = PeopleinoutManage::find($request->pio_id);
			if(!$pio){
				$pio=new PeopleinoutManage();
				$pio::create($request->all());
			}else{
				$pio->update($request->except('pio_id','_token'));
			}
		} catch (\Exception $e) {
			//写入日志 保存失败
			report($e);
			return $this->error('保存失败');
		}
		return $this->success(route('admin.storageroommanage.peopleinoutmanage'),'成功');
	}

	/**
	 * delete
	 *
	 * @author lwb 20180331
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function delete($id)
	{
		// 删除
		try {
			if (PeopleinoutManage::destroy($id)){
				return redirect(route('admin.storageroommanage.peopleinoutmanage'));
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
		$exhibit_Logout=new PeopleinoutManage();
		//选中的所有数据
		$res = $exhibit_Logout->whereIn("pio_id", $apply_ids)->get()->toArray();
		$xls_data = array();
		$header = ['库房编号','入库时间','计划出库时间',
			'实际出库时间','入库人员','陪同人员','进库人单位','出入事由','备注'];
		$xls_data[] = $header;
		foreach($res as $k=> $v)
		{
			$xls_data[] = array(
				$v['storeroom_id'],
				$v['comein_time'],
				$v['plan_goout_time'],
				$v['real_goout_time'],
				$v['comein_member'],
				$v['with_member'],
				$v['comein_department'],
				$v['reason'],
				$v['remark']
			);
		}
		Excel::create('人员出入管理表', function ($excel) use ($xls_data) {
			$excel->sheet('score', function ($sheet) use ($xls_data) {
				$sheet->setWidth(array(
					'A'     => 20,
					'B'     =>  25,
					'C'     =>  25,
					'D'     =>  25,
					'E'     =>  25,
					'F'     =>  25,
					'G'     =>  25,
					'H'     =>  25,
					'I'     =>  25,
					'J'     =>  25,
				));
				$sheet->rows($xls_data);
			});
		})->export('xls');

	}
}