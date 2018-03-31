<?php

namespace App\Http\Controllers\Admin\Storageroommanage;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;

/**
 * Class RoomStructController
 *
 * @author lxp
 * @package App\Http\Controllers\Admin\Setting
 */
class RoomStructController extends BaseAdminController
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
        $item['name'] = '珍贵文物库房';
        $item['num'] = 'TDF110';
        $item['is_kuwei'] = '是';
        $item['kufang_type'] = '一级库房';
        $item['storage_way'] = '';
        $item['kufang_size'] = '50平';
        $item['is_valid'] = '生效';
        $item['position'] = '一楼';
        $item['charity'] = '张三';

        $item1['name'] = '珍贵文物库房2';
        $item1['num'] = 'TDF111';
        $item1['is_kuwei'] = '是';
        $item1['kufang_type'] = '一级库房';
        $item1['storage_way'] = '';
        $item1['kufang_size'] = '50平';
        $item1['is_valid'] = '生效';
        $item1['position'] = '一楼';
        $item1['charity'] = '张三';

		return view('admin.storageroommanage.roomstruct', [
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
		return view('admin.storageroommanage.roomstruct_form');
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
		return view('admin.storageroommanage.roomstruct_form', [
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