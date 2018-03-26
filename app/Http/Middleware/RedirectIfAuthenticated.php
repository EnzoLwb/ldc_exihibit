<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @param  string|null $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		if (Auth::guard($guard)->check()) {
			// 根据当前guard决定要跳转到哪个页面
			$url = (Auth::getDefaultDriver() == 'admin') ? route('admin.index') : '/home';
			return redirect($url);
		}

		return $next($request);
	}
}
