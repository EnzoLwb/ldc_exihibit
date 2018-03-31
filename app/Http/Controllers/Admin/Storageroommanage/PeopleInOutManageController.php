<?php

namespace App\Http\Controllers\Admin\Storageroommanage;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\PeopleinoutManagePost;
use App\Models\Storageroommanage\PeopleinoutManage;
use Illuminate\Http\Request;

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
		$pio_data=PeopleinoutManage::paginate(15);
		return view('admin.storageroommanage.peopleInOutManage', [
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
		return $this->success(get_session_url('index'));
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
}