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
	    $item['logout_num'] = 'ADAD0001';
        $item['logout_name'] = '兵符注销';
        $item['logout_date'] = '2018-02-09';
        $item['logout_pizhun_num'] = '3535123';
        $item['logout_reason'] = '文物损坏';
        $item['logout_desc'] = '文物损坏严重';
        $item['register'] = '张三';
        $item['register_date'] = '2018-02-01';

        $item1['logout_num'] = 'ADAD0001';
        $item1['logout_name'] = '玉玺注销';
        $item1['logout_date'] = '2018-02-09';
        $item1['logout_pizhun_num'] = '3535123';
        $item1['logout_reason'] = '文物损坏';
        $item1['logout_desc'] = '文物损坏严重';
        $item1['register'] = '李四';
        $item1['register_date'] = '2018-02-01';
		return view('admin.exhibitlogout.exhibitlogout', [
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