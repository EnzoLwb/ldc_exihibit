<?php

namespace App\Http\Controllers\Admin\Storageroommanage;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;

/**
 * Class RoomlistController
 *
 * @author lxp
 * @package App\Http\Controllers\Admin\Setting
 */
class RoomlistController extends BaseAdminController
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
	    $item['charity_people'] = '张三';
        $item['check_date'] = '2018-03-10';
        $item['check_exhibit_count'] = '1';
        $item['whole_exhibit_count'] = '1';
        $item['half_exhibit_count'] = '0';
        $item['mark'] = '';


        $item1['charity_people'] = '李四';
        $item1['check_date'] = '2018-03-10';
        $item1['check_exhibit_count'] = '2';
        $item1['whole_exhibit_count'] = '1';
        $item1['half_exhibit_count'] = '1';
        $item1['mark'] = '';


        return view('admin.storageroommanage.roomlist', [
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
		return view('admin.storageroommanage.roomlist_form');
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