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
class RepairInController extends BaseAdminController
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
        $item['file_num'] = 'ERE001';
        $item['exhibit_name'] = '玉龙玉玺';
        $item['take_date'] = '2018-03-01';
        $item['repair_date'] = '2018-03-11';
        $item['back_date'] = '2018-03-20';
        $item['responser'] = '张三';
        $item['repairer'] = '李四';
        $item['exhibit_status'] = '修复完成';


        $item1['file_num'] = 'ERE002';
        $item1['exhibit_name'] = '诚王兵符';
        $item1['take_date'] = '2018-03-06';
        $item1['repair_date'] = '2018-03-16';
        $item1['back_date'] = '2018-03-26';
        $item1['responser'] = '张三';
        $item1['repairer'] = '李四';
        $item1['exhibit_status'] = '修复完成';

        return view('admin.repaireexhibit.repairin', [
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
		return view('admin.repaireexhibit.repairin_form');
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
		return view('admin.repaireexhibit.repairin_form', [
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