<?php

namespace App\Http\Controllers\Admin\RepaireExhibit;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;

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
	public function index()
	{
        $item['repair_num'] = 'DSA001';
        $item['repair_name'] = '陈展部';
        $item['fee'] = '10万';
        $item['status'] = '未审批';
        $item['register_date'] = '2018-03-01';

        $item1['repair_num'] = 'DSA002';
        $item1['repair_name'] = '文化部';
        $item1['fee'] = '12万';
        $item1['status'] = '未审批';
        $item1['register_date'] = '2018-03-11';
		return view('admin.repaireexhibit.apply', [
			'data' => [$item, $item1]
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
		return view('admin.repaireexhibit.apply_form', [
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