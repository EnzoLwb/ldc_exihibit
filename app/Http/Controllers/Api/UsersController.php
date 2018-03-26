<?php

namespace App\Http\Controllers\Api;

use App\Dao\SmsVerifyDao;
use App\Dao\UploadedFileDao;
use App\Exceptions\ApiErrorException;
use App\Models\Users;
use App\Models\UsersBind;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersController extends Controller
{
	public function __construct()
	{
		parent::_init();
	}

	/**
	 * 用户登录
	 *
	 * @author lxp 20170113
	 * @return \Illuminate\Http\JsonResponse
	 * @throws ApiErrorException
	 *
	 * @api {POST} /users/login 1. 用户登录
	 * @apiGroup Users
	 * @apiVersion 1.0.0
	 * @apiParam {string} p 平台，i：IOS，a：安卓，w：Web，t：触屏或手机
	 * @apiParam {string} phone 手机号
	 * @apiParam {string} password 密码
	 * @apiParam {string} [deviceno] 设备号
	 * @apiSuccess {int} uid 用户ID
	 * @apiSuccess {string} api_token 用户签名
	 * @apiSuccessExample {json} 返回值
	 * {"status":1,"data":{"uid":2,"api_token":"a40c76e4bc07a77f7f322530987d818e"},"msg":""}
	 */
	public function login()
	{
		$this->validate([
			'phone' => 'required',
			'password' => 'required'
		]);

		// 取出用户并验证密码
		$user = Users::where('username', request('phone'))->first();
		if (is_null($user)) {
			throw new ApiErrorException('该手机号尚未注册，请先注册');
		}
		if (get_password(request('password'), $user->salt) != $user->password) {
			throw new ApiErrorException('用户名或密码错误');
		}

		// 登录成功，生成api token
		$user->api_token = get_api_token($user->uid);
		if (request('deviceno')) {
			$user->deviceno = request('deviceno');
		}
		$user->save();

		return response_json(1, [
			'uid' => $user->uid,
			'api_token' => $user->api_token
		]);
	}

	/**
	 * 用户详情
	 *
	 * @author lxp 20170905
	 * @return \Illuminate\Http\JsonResponse
	 *
	 * @api {GET} /users/info 5. 用户详情
	 * @apiGroup Users
	 * @apiVersion 1.0.0
	 * @apiParam {string} p 平台，i：IOS，a：安卓，w：Web，t：触屏或手机
	 * @apiParam {string} api_token 用户签名
	 * @apiSuccess {object} data 用户数据
	 * @apiSuccess {int} data.uid 用户ID
	 * @apiSuccess {int} data.user_type_id 会员类型id
	 * @apiSuccess {string} data.phone 手机号
	 * @apiSuccess {string} data.nickname 昵称
	 * @apiSuccess {string} data.avatar 头像
	 * @apiSuccessExample {json} 返回值
	 * {"status":1,"data":{"uid":1,"phone":13812341234,"nickname":"U13812341234","avatar":"\/uploadfiles\/avatar\/20170905\/201709051344549521.jpg"},"msg":""}
	 */
	public function info()
	{
		$uid = Auth::user()->uid;
		$uinfo = Users::where('uid', $uid)->first();

		return response_json(1, [
			'uid' => $uinfo->uid,
			'phone' => $uinfo->phone,
			'nickname' => $uinfo->nickname,
			'avatar' => $uinfo->avatar,
		]);
	}

	/**
	 * 修改头像
	 *
	 * @author lxp 20170905
	 * @return \Illuminate\Http\JsonResponse
	 * @throws ApiErrorException
	 *
	 * @api {POST} /users/avatar 修改头像
	 * @apiGroup Users
	 * @apiVersion 1.0.0
	 * @apiParam {string} p 平台，i：IOS，a：安卓，w：Web，t：触屏或手机
	 * @apiParam {string} api_token 用户签名
	 * @apiParam {file} avatar 头像
	 * @apiSuccess {string} data 新头像地址
	 * @apiSuccessExample {json} 返回值
	 * {"status":1,"data":"\u65b0\u6635\u79f0","msg":""}
	 */
	public function avatar()
	{
		$this->validate([
			'avatar' => 'required|file'
		]);
		$uid = Auth::user()->uid;

		// 保存图片
		$file = UploadedFileDao::saveFile('avatar', 'FT_AVATAR', $uid);
		if (!$file['status']) {
			throw new ApiErrorException($file['data']);
		}

		$users = Users::findOrFail($uid);
		$users->timestamps = false;
		$users->avatar = $file['data']->file_path . '/' . $file['data']->file_name;
		$users->save();

		return response_json(1, $users->avatar);
	}

	/**
	 * 修改昵称
	 *
	 * @author lxp 20170905
	 * @return \Illuminate\Http\JsonResponse
	 *
	 * @api {POST} /users/nickname 修改昵称
	 * @apiGroup Users
	 * @apiVersion 1.0.0
	 * @apiParam {string} p 平台，i：IOS，a：安卓，w：Web，t：触屏或手机
	 * @apiParam {string} api_token 用户签名
	 * @apiParam {string} nickname 昵称
	 * @apiSuccess {string} data 新昵称
	 * @apiSuccessExample {json} 返回值
	 * {"status":1,"data":"\u65b0\u6635\u79f0","msg":""}
	 */
	public function nickname()
	{
		$uid = Auth::user()->uid;
		$this->validate([
			'nickname' => 'required|unique:users,nickname,' . $uid . ',uid'
		]);
		$users = Users::findOrFail($uid);
		$users->timestamps = false;
		$users->nickname = request('nickname');
		$users->save();

		return response_json(1, $users->nickname);
	}

	/**
	 * 用户注册
	 *
	 * @author lxp 20170810
	 * @return \Illuminate\Http\JsonResponse
	 * @throws ApiErrorException
	 *
	 * @api {POST} /users/register 2. 用户注册
	 * @apiGroup Users
	 * @apiVersion 1.0.0
	 * @apiParam {string} p 平台，i：IOS，a：安卓，w：Web，t：触屏或手机
	 * @apiParam {string} phone 手机号
	 * @apiParam {string} password 密码
	 * @apiParam {string} smscode 短信验证码
	 * @apiSuccess {int} uid 用户ID
	 * @apiSuccess {string} phone 手机号
	 * @apiSuccess {string} api_token 用户签名
	 * @apiSuccessExample {json} 返回值
	 * {"status":1,"data":{"uid":2,"username":"13112341234","phone":"13112341234","api_token":"a40c76e4bc07a77f7f322530987d818e"},"msg":""}
	 */
	public function register()
	{
		$this->validate([
			'phone' => 'required|mobile|unique:users,username',
			'password' => 'required|min:6|max:32',
			'smscode' => 'required'
		]);

		// 短信验证码
		SmsVerifyDao::code_check(request('phone'), request('smscode'));

		$user = DB::transaction(function () {
			// 生成密码盐
			$salt = Str::random(6);

			$user = new Users();
			$user->username = request('phone');
			$user->password = get_password(request('password'), $salt);
			$user->phone = request('phone');
			$user->nickname = UsersDao::get_nickname();
			$user->salt = $salt;
			$user->lastloginip = app('request')->ip();
			$user->plat = request('p');
			$user->save();
			if (!$user->uid) {
				throw new ApiErrorException('注册失败，请稍后重试');
			}
			// 生成API验证token
			$user->api_token = get_api_token($user->uid);
			$user->save();

			return $user;
		});
		return response_json(1, [
			'uid' => $user->uid,
			'phone' => $user->phone,
			'api_token' => $user->api_token
		]);
	}

	/**
	 * 第三方账号绑定注册
	 *
	 * @author lxp 20170915
	 * @return \Illuminate\Http\JsonResponse
	 *
	 * @api {POST} /users/register_bind 8. 第三方账号绑定注册
	 * @apiGroup Users
	 * @apiVersion 1.0.0
	 * @apiParam {string} p 平台，i：IOS，a：安卓，w：Web，t：触屏或手机
	 * @apiParam {string} phone 手机号
	 * @apiParam {string} smscode 短信验证码
	 * @apiParam {string} openid 第三方id
	 * @apiParam {string="wx","wb","qq"} b_from 来源
	 * @apiParam {string} b_nickname 第三方昵称
	 * @apiParam {string} [b_avatar] 第三方头像url
	 * @apiSuccess {int} uid 用户ID
	 * @apiSuccess {string} phone 手机号
	 * @apiSuccess {string} api_token 用户签名
	 * @apiSuccessExample {json} 返回值
	 * {"status":1,"data":{"uid":2,"username":"13112341234","phone":"13112341234","api_token":"a40c76e4bc07a77f7f322530987d818e"},"msg":""}
	 */
	public function register_bind()
	{
		$this->validate([
			'phone' => 'required|mobile|unique:users',
			'smscode' => 'required',
			'openid' => 'required',
			'b_from' => 'required|in:wx,qq,wb',
			'b_nickname' => 'required',
		]);

		// 短信验证码
		SmsVerifyDao::code_check(request('phone'), request('smscode'));

		$user = DB::transaction(function () {
			// 处理昵称
			$nickname = trim(strip_tags(request('b_nickname')));
			if (Users::where('nickname', $nickname)->count() > 0) {
				$nickname = UsersDao::get_nickname($nickname);
			}
			// 生成密码盐
			$salt = Str::random(6);

			// 添加用户
			$user = new Users();
			$user->username = request('phone');
			$user->password = get_password(Str::random(6), $salt);
			$user->phone = request('phone');
			$user->nickname = $nickname;
			$user->salt = $salt;
			$user->lastloginip = app('request')->ip();
			$user->plat = request('p');
			$user->save();
			if (!$user->uid) {
				throw new ApiErrorException('注册失败，请稍后重试');
			}
			// 保存头像
			if (request('b_avatar')) {
				$file = UploadedFileDao::saveRemoteFile(request('b_avatar'), 'FT_AVATAR', $user->uid);
				if ($file['status']) {
					$user->avatar = $file['data']->file_path . '/' . $file['data']->file_name;
				}
			}
			// 生成API验证token
			$user->api_token = get_api_token($user->uid);
			$user->save();

			// 添加绑定信息
			$userBind = new UsersBind();
			$userBind->uid = $user->uid;
			$userBind->openid = request('openid');
			$userBind->b_from = request('b_from');
			$userBind->b_nickname = request('b_nickname');
			$userBind->b_avatar = request('b_avatar', '');
			$userBind->save();

			return $user;
		});
		return response_json(1, [
			'uid' => $user->uid,
			'phone' => $user->phone,
			'api_token' => $user->api_token
		]);
	}

	/**
	 * 第三方账号登录
	 *
	 * @author lxp 20170915
	 * @return \Illuminate\Http\JsonResponse
	 * @throws ApiErrorException
	 *
	 * @api {POST} /users/login_bind 9. 第三方账号登录
	 * @apiGroup Users
	 * @apiVersion 1.0.0
	 * @apiParam {string} p 平台，i：IOS，a：安卓，w：Web，t：触屏或手机
	 * @apiParam {string} openid 第三方id
	 * @apiParam {string="wx","wb","qq"} b_from 来源
	 * @apiParam {string} [deviceno] 设备号
	 * @apiSuccess {int} uid 用户ID
	 * @apiSuccess {string} api_token 用户签名
	 * @apiSuccessExample {json} 返回值
	 * {"status":1,"data":{"uid":2,"api_token":"a40c76e4bc07a77f7f322530987d818e"},"msg":""}
	 */
	public function login_bind()
	{
		$this->validate([
			'openid' => 'required',
			'b_from' => 'required|in:wx,qq,wb',
		]);

		// 取出用户绑定数据
		$userbind = UsersBind::where('openid', request('openid'))->where('b_from', request('b_from'))->first();
		if (is_null($userbind)) {
			throw new ApiErrorException('用户不存在');
		}

		$user = Users::findOrFail($userbind->uid);
		// 登录成功，生成api token
		$user->api_token = get_api_token($user->uid);
		if (request('deviceno')) {
			$user->deviceno = request('deviceno');
		}
		$user->save();

		return response_json(1, [
			'uid' => $user->uid,
			'api_token' => $user->api_token
		]);
	}

	/**
	 * 短信认证，忘记（修改）密码
	 *
	 * @author lxp 20170113
	 * @return \Illuminate\Http\JsonResponse
	 * @throws ApiErrorException
	 *
	 * @api {POST} /users/password 4. 忘记（修改）密码
	 * @apiGroup Users
	 * @apiVersion 1.0.0
	 * @apiParam {string} p 请求平台，i：IOS，a：安卓，w：Web，t：触屏或手机
	 * @apiParam {string} phone 手机号
	 * @apiParam {string} smscode 短信验证码
	 * @apiParam {string} password 新密码
	 * @apiParam {string} password_confirmation 确认密码
	 * @apiSuccess {string} username 用户名
	 * @apiSuccess {string} api_token 用户签名
	 * @apiSuccessExample {json} 返回值
	 * {"status":1,"data":{"username":"admin","api_token":"708a71f7be9987d5e02b5ba23b144121"},"msg":""}
	 */
	public function password()
	{
		$this->validate([
			'phone' => 'required|mobile',
			'smscode' => 'required',
			'password' => 'required|min:6|max:32|confirmed',
			'password_confirmation' => 'required'
		]);

		$user = Users::where('phone', request('phone'))->first();
		if (!$user) {
			throw new ApiErrorException('用户不存在');
		}

		// 短信验证码
		SmsVerifyDao::code_check(request('phone'), request('smscode'));

		// 新密码不与老密码相同，允许修改密码
		if (get_password(request('password'), $user->salt) != $user->password) {
			$user->timestamps = false;
			$user->salt = Str::random(6);
			$user->password = get_password(request('password'), $user->salt);
			$user->remember_token = Str::random(60);
			$user->api_token = get_api_token($user->uid);
			$user->save();
		}

		return response_json(1, [
			'username' => $user->username,
			'api_token' => $user->api_token
		]);
	}

	/**
	 * 登出（清除设备号）
	 *
	 * @author lxp 20170905
	 * @return \Illuminate\Http\JsonResponse
	 *
	 * @api {GET} /users/logout 6. 用户登出（清除设备号）
	 * @apiGroup Users
	 * @apiVersion 1.0.0
	 * @apiParam {string} p 平台，i：IOS，a：安卓，w：Web，t：触屏或手机
	 * @apiParam {string} api_token 用户签名
	 * @apiSuccessExample {json} 返回值
	 * {"status":1,"data":[],"msg":""}
	 */
	public function logout()
	{
		$uid = Auth::user()->uid;
		$user = Users::findOrFail($uid);
		$user->deviceno = null;
		$user->api_token = null;
		$user->save();

		return response_json(1);
	}
}
