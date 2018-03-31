<?php

namespace App\Http\Controllers\Admin\Exhibitshow;

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
        $item['applyer'] = '张三';
        $item['apply_date'] = '2018-03-10';
        $item['show_theme'] = '西晋文化展览';
        $item['show_iner'] = '李四...';
        $item['show_num'] = 'NIK001';
        $item['show_start_date'] = '2018-01-01';
        $item['show_end_date'] = '2018-01-01';
        $item['position'] = '3号展位';

        $item1['applyer'] = '李四';
        $item1['apply_date'] = '2018-03-10';
        $item1['show_theme'] = '文化展览';
        $item1['show_iner'] = '李四...';
        $item1['show_num'] = 'NIK001';
        $item1['show_start_date'] = '2018-01-01';
        $item1['show_end_date'] = '2018-01-01';
        $item1['position'] = '4号展位';
		return view('admin.exhibitshow.apply', [
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
		return view('admin.exhibitshow.apply_form');
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
		return view('admin.exhibitshow.apply_form', [
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