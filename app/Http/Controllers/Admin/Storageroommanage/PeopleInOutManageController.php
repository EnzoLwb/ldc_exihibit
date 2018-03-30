<?php

namespace App\Http\Controllers\Admin\Storageroommanage;

use App\Http\Controllers\Admin\BaseAdminController;
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

		return view('admin.storageroommanage.peopleInOutManage', [
			'data' => []
		]);
	}

	/**
	 * 新增
	 *
	 * @author lwb 2018 0330
	 * @param  Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{
		return view('admin.storageroommanage.peopleinpout_form');
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
		return view('admin.storageroommanage.roomlist_form', [
			'data' => []
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
		$this->validate($request, []);

		// 保存数据

		return $this->success(get_session_url('index'));
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

		return $this->success('', 's_del');
	}
}