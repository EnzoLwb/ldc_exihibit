<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class MEloquentUserProvider extends EloquentUserProvider
{

	/**
	 * 覆写密码验证
	 *
	 * @author lxp 20170105
	 * @param UserContract $user
	 * @param array $credentials
	 * @return bool
	 */
	public function validateCredentials(UserContract $user, array $credentials)
	{
		return get_password($credentials['password'], $user->salt) === $user->getAuthPassword();
	}

}