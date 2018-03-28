<?php

namespace App\Http\Controllers\Admin\Exhibitlogout;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;

/**
 * Class ExhibitlogoutContrller
 *
 * @author lxp
 * @package App\Http\Controllers\Admin\Setting
 */
class ExhibitlogoutController extends BaseAdminController
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
	public function index()
	{

		return view('admin.exhibitlogout.exhibitlogout', [
			'data' => []
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
		return view('admin.exhibitlogout.exhibitlogout_form');
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
		return view('admin.exhibitlogout.exhibitlogout_form', [
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