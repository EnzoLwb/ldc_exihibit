<?php

namespace App\Providers;

use App\Http\Controllers\Auth\AdminEloquentUserProvider;
use App\Http\Controllers\Auth\MEloquentUserProvider;
use App\Models\AdminGroup;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		'App\Model' => 'App\Policies\ModelPolicy',
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerPolicies();

		// 权限认证 lxp 20170110
		Gate::define('priv', function ($user, $actionName = '') {

			if ($actionName == '') {
				$actionArray = Route::getCurrentRoute()->getActionName();

				preg_match("/^[^\\\\]+\\\\[^\\\\]+\\\\[^\\\\]+\\\\([^@]+)@(.*)$/i", $actionArray, $actionMatch);
				// 取得当前要访问的控制器
				$actionName = str_replace([
					'\\',
					'controller'
				], [
					'-',
					''
				], strtolower($actionMatch[1]));
				// 取得当前访问的方法，用于以后控制权限
				$action = strtolower($actionMatch[2]);

				// 临时匹配控制器的所有方法
				$actionName .= ':*';
			}

			// 首页都有权限访问
			if ($actionName == 'admin-home' || $actionName == 'admin-home:*'
                || $actionName =="admin-excel-excel"  || $actionName=='admin-excel-excel:*'
                || $actionName=='admin-repaireexhibit-repairout' || $actionName=='admin-repaireexhibit-repairout:*') {
				return true;
			}

			$groupid = $user->groupid;
			if ($groupid) {
				// 取出当前用户所在用户组权限
				$groupPrivs = AdminGroup::findOrNew($groupid)->privs;

				// 超级管理员
				if ($groupPrivs == 'all') {
					return true;
				}
				$groupPrivs = json_decode($groupPrivs, true);


				// 判断当前操作是否有权限
				if (is_array($groupPrivs)) {
					// 此处只对左侧菜单列表做了判断，如有需要可对每个请求方法做权限验证

					if (substr($actionName, -2) == ':*') {
						$actionName = substr($actionName, 0, -2);

						foreach ($groupPrivs as $gp) {


							if ($actionName == substr($gp, 0, strpos($gp, ':')) || $actionName == $gp) {

								return true;
							}
						}
					} elseif (in_array($actionName, $groupPrivs)) {
						return true;
					}
				}
			}
			return false;
		});

		// 注册自定义UserProvider lxp 20170105
		Auth::provider('meloquent', function ($app, array $config) {
			return new MEloquentUserProvider($app['hash'], $config['model']);
		});
		// 注册自定义后台UserProvider lxp 20170110
		Auth::provider('admineloquent', function ($app, array $config) {
			return new AdminEloquentUserProvider($app['hash'], $config['model']);
		});
	}
}

