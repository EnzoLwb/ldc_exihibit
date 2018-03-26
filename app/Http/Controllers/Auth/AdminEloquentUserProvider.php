<?php
namespace App\Http\Controllers\Auth;

use App\Models\AdminUser;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class AdminEloquentUserProvider extends EloquentUserProvider
{

	/**
	 * 后台用户覆写密码验证
	 *
	 * @author lxp 20170110
	 * @param UserContract $user
	 * @param array $credentials
	 * @return bool
	 */
	public function validateCredentials(UserContract $user, array $credentials)
	{
		return get_password($credentials['password'], $user->salt) === $user->getAuthPassword();
	}
}