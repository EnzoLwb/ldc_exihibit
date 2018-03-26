<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\AdminGroup;
use App\Models\AdminUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * 管理员控制器
 *
 * @author lxp
 * @package App\Http\Controllers\User
 */
class AdminUsersController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 管理员列表
	 *
	 * @author lxp 20170203
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		// 处理排序
		$sort = request('sort', 'uid');
		$order = request('order', 'asc');

		$query = AdminUsers::orderBy($sort, $order)->where('uid', '<>', 1);
		// 筛选用户名
		if (request('username')) {
			$query->where('admin_users.username', 'LIKE', "%" . request('username') . "%");
		}
		// 筛选注册时间
		if (request('created_at_from')) {
			$query->where('admin_users.created_at', '>=', request('created_at_from'));
		}
		if (request('created_at_to')) {
			$query->where('admin_users.created_at', '<=', date('Y-m-d', strtotime(request('created_at_to') . " +1 day")));
		}
		// 取得列表
		$users = $query->leftJoin('admin_group', 'admin_group.groupid', 'admin_users.groupid')->select('admin_users.*', 'admin_group.groupname')->paginate(parent::PERPAGE);
		// 将查询参数拼接到分页链接中
		$users->appends(app('request')->all());

		return view('admin.setting.adminusers', [
			'users' => $users
		]);
	}

	/**
	 * 添加管理员
	 *
	 * @author lxp 20170206
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{
		// 取得所有用户组
		$userGroups = AdminGroup::where('groupid', '<>', 1)->get();

		return view('admin.setting.adminusers_form', [
			'userGroups' => $userGroups
		]);
	}

	/**
	 * 编辑管理员
	 *
	 * @author lxp 20170111
	 * @param int $uid 用户id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($uid)
	{
		// 取得用户信息
		$user = AdminUsers::findOrFail($uid);
		// 取得所有用户组
		$userGroups = AdminGroup::where('groupid', '<>', 1)->get();

		return view('admin.setting.adminusers_form', [
			'user' => $user,
			'userGroups' => $userGroups
		]);
	}

	/**
	 * 保存用户
	 *
	 * @author lxp 20170204
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function save()
	{
		// 验证
		if (request('uid')) {
			$this->validate(request(), [
				'password' => 'nullable|min:6',
				'email' => [
					'nullable',
					'email',
					Rule::unique('admin_users', 'email')->ignore(request('uid'), 'uid'),
					'max:255'
				],
				'phone' => 'nullable|mobile|unique:admin_users,phone,' . request('uid') . ',uid',
				'groupid' => 'required'
			]);
		} else {
			$this->validate(request(), [
				'username' => 'required|max:20|unique:admin_users',
				'email' => 'nullable|email|unique:admin_users|max:255',
				'phone' => 'nullable|mobile|unique:admin_users',
				'password' => 'required|min:6',
				'groupid' => 'required'
			]);
		}
		// 保存用户信息
		$user = AdminUsers::findOrNew(request('uid', 0));
		// 屏蔽 timestamps，阻止时间戳自动更新
		$user->timestamps = false;
		if (!request('uid')) {
			// 添加
			$user->username = request('username');
			$user->created_at = date('Y-m-d H:i:s');
		}
		$user->nickname = request('nickname');
		$user->groupid = request('groupid');
		$user->email = request('email');
		$user->phone = request('phone');
		if (request()->has('password')) {
			// 处理密码
			$user->salt = Str::random(6);
			$user->password = get_password(request('password'), $user->salt);
		}
		$user->save();
		return $this->success(get_session_url('index'));
	}

	/**
	 * 删除用户
	 *
	 * @author lxp 20160713
	 * @param int $uid
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function delete($uid)
	{
		if (request()->ajax() && intval($uid)) {
			// 判断用户是否可以被删除

			// 删除用户，不能删除admin
			$uid != 1 && AdminUsers::destroy($uid);

			return $this->success();
		}
	}

	/**
	 * 管理员修改密码
	 *
	 * @author lxp 20170303
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function password()
	{
		if (request()->isMethod('POST')) {
			// 验证老密码
			$userObj = Auth::user();
			if (get_password(request('old_password'), $userObj->salt) !== $userObj->password) {
				// 手动报错
				return response()->json([
					'old_password' => trans('msg.e_adminusers_password')
				], 422);
			}
			// 验证新密码
			$this->validate(request(), [
				'password' => 'required|min:6|confirmed',
			]);

			$userObj->timestamps = false;
			$userObj->salt = Str::random(6);
			$userObj->password = get_password(request('password'), $userObj->salt);
			$userObj->save();

			return $this->success();
		} else {
			return view('admin.setting.password');
		}
	}
}