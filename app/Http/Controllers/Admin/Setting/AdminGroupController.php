<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\AdminGroup;
use App\Models\AdminUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * 用户组控制器
 *
 * @author lxp 20160621
 * @package App\Http\Controllers\User
 */
class AdminGroupController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 用户组列表
	 *
	 * @author lxp 20170111
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$query = AdminGroup::orderBy('groupid')->where('groupid', '<>', 1);
		// 取得列表
		$userGroups = $query->paginate(parent::PERPAGE);
		// 将查询参数拼接到分页链接中
		$userGroups->appends(app('request')->all());

		return view('admin.setting.admingroup', [
			'userGroup' => $userGroups
		]);
	}

	/**
	 * 添加用户组
	 *
	 * @author lxp 20160621
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{
		return view('admin.setting.admingroup_form');
	}

	/**
	 * 编辑用户组
	 *
	 * @author lxp 20160622
	 * @param int $groupid
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($groupid)
	{
		$ugroup = AdminGroup::findOrFail($groupid);
		// 不允许修改超级管理员权限
		if ($ugroup->privs == 'all') {
			return redirect(get_session_url('index'));
		}
		// 处理权限数据
		$ugroup->privs = json_decode($ugroup->privs, true);
		return view('admin.setting.admingroup_form', [
			'ugroup' => $ugroup
		]);
	}

	/**
	 * 保存用户组
	 *
	 * @author lxp 20170204
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function save(Request $request)
	{
		// 验证
		$this->validate($request, [
			'groupname' => 'required' . (request('groupid') ? '' : '|unique:admin_group'),
			'privs' => 'required'
		]);

		// 保存数据
		$userGroup = AdminGroup::findOrNew(request('groupid', 0));
		$userGroup->groupname = request('groupname');
		$userGroup->privs = json_encode(request('privs'));
		$userGroup->save();

		// 清除缓存
		Cache::forget('group_privs:' . $userGroup->groupid);

		return $this->success(get_session_url('index'));
	}

	/**
	 * 删除用户组
	 *
	 * @author lxp 20170204
	 * @param $groupid
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function delete($groupid)
	{
		// 判断当前用户组下是否有用户
		if (AdminUsers::where('groupid', $groupid)->count() > 0) {
			return $this->error('e_usergroup_hasuser');
		}
		// 删除
		AdminGroup::destroy($groupid);
		// 清除缓存
		Cache::forget('group_privs:' . $groupid);

		return $this->success('', 's_del');
	}
}