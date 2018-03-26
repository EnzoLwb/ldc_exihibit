<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\UploadedFile;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 用户控制器
 *
 * @author lxp
 * @package App\Http\Controllers\User
 */
class UsersController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 用户列表
	 *
	 * @author lxp 20170111
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		// 处理排序
		$sort = request('sort', 'uid');
		$order = request('order', 'desc');

		$query = Users::orderBy($sort, $order);
		// 筛选用户名
		if (request('username')) {
			if (is_email(request('username'))) {
				$query->where('email', request('username'));
			} elseif (is_mobile(request('username'))) {
				$query->where('phone', request('username'));
			} else {
				$query->where('username', 'LIKE', "%" . request('username') . "%");
			}
		}
		// 筛选注册时间
		if (request('created_at_from')) {
			$query->where('created_at', '>=', request('created_at_from'));
		}
		if (request('created_at_to')) {
			$query->where('created_at', '<=', date('Y-m-d', strtotime(request('created_at_to') . " +1 day")));
		}
		// 取得列表
		$users = $query->paginate(parent::PERPAGE);
		// 将查询参数拼接到分页链接中
		$users->appends(app('request')->all());

		return view('admin.user.users', [
			'users' => $users,
		]);
	}

	/**
	 * 添加用户
	 *
	 * @author lxp 20170825
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{
		return view('admin.user.users_form');
	}

	/**
	 * 编辑用户
	 *
	 * @author lxp 20170111
	 * @param $uid
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($uid)
	{
		// 取得用户信息
		$user = Users::findOrFail($uid);

		return view('admin.user.users_form', [
			'user' => $user
		]);
	}

	/**
	 * 保存用户
	 *
	 * @author lxp 20170206
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function save()
	{
		// 验证
		$rule = [
			'phone' => 'required|mobile|unique:users,phone,' . request('uid') . ',uid',
			'nickname' => 'required|unique:users,nickname,' . request('uid') . ',uid'
		];
		if (!request('uid')) {
			$rule = array_merge([
				'username' => 'required|unique:users,username,' . request('uid') . ',uid',
				'password' => 'required|min:6'
			], $rule);
		} else {
			$rule = array_merge([
				'password' => 'nullable|min:6'
			], $rule);
		}
		$this->validate(request(), $rule);

		// 保存用户信息
		DB::transaction(function () {
			$user = Users::findOrNew(request('uid'));
			if (!request('uid')) {
				$user->username = request('username');
			} else {
				// 屏蔽 timestamps，阻止时间戳自动更新
				$user->timestamps = false;
			}
			$user->nickname = request('nickname');
			$user->email = request('email');
			$user->phone = request('phone');
			if (request()->has('password')) {
				// 处理密码
				$user->salt = Str::random(6);
				$user->password = get_password(request('password'), $user->salt);
			}
			$user->avatar = request('avatar');
			$user->save();

			// 更新附件id
			if (!request('uid')) {
				// 更新头像
				if (intval(request('avatar_file_id'))) {
					UploadedFile::where('file_id', intval(request('avatar_file_id')))->update(['item_id' => $user->uid]);
				}
			}
		});

		return $this->success(get_session_url('index'));
	}

	/**
	 * 删除用户
	 *
	 * @author lxp 20160713
	 * @param int $uid
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete($uid)
	{
		if (request()->ajax() && intval($uid)) {
			// 判断用户是否可以被删除

			// 删除用户
			Users::destroy($uid);

			return $this->success();
		}
	}
}