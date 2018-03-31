<?php

namespace App\Http\Controllers\Admin\Exhibitshow;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;

/**
 * Class ShowController
 *
 * @author lxp
 * @package App\Http\Controllers\Admin\Setting
 */
class ShowController extends BaseAdminController
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
        $item['show_num'] = 'UDS0001';
        $item['show_name'] = '西晋文化展';
        $item['show_start_date'] = '2018-01-01';
        $item['show_end_date'] = '2018-02-01';
        $item['show_theme'] = '西晋文化展';
        $item['register'] = '张三';
        $item['register_date'] = '2017-12-30';

        $item1['show_num'] = 'UDS0002';
        $item1['show_name'] = '西晋文化展续';
        $item1['show_start_date'] = '2018-01-01';
        $item1['show_end_date'] = '2018-02-01';
        $item1['show_theme'] = '西晋文化展续';
        $item1['register'] = '李四';
        $item1['register_date'] = '2017-12-30';

		return view('admin.exhibitshow.show', [
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
		return view('admin.exhibitshow.show_form');
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
		return view('admin.exhibitshow.show_form', [
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