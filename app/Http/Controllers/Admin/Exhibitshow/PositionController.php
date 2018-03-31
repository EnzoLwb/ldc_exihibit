<?php

namespace App\Http\Controllers\Admin\Exhibitshow;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;

/**
 * Class PositionController
 *
 * @author lxp
 * @package App\Http\Controllers\Admin\Setting
 */
class PositionController extends BaseAdminController
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
        $item['position_name'] = '1号展位';
        $item['position_num'] = '0001';
        $item['exhibit_way'] = '陈列展示';
        $item['is_class'] = '是';
        $item['is_valid'] = '是';
        $item['position'] = '一楼';
        $item['responser'] = '张三';



        $item1['position_name'] = '2号展位';
        $item1['position_num'] = '0002';
        $item1['exhibit_way'] = '陈列展示';
        $item1['is_class'] = '是';
        $item1['is_valid'] = '是';
        $item1['position'] = '一楼';
        $item1['responser'] = '李四';

		return view('admin.exhibitshow.position', [
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
		return view('admin.exhibitshow.position_form');
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
		return view('admin.exhibitshow.position_form', [
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