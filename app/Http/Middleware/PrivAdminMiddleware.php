<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class PrivAdminMiddleware
{
	/**
	 * 权限验证中间件
	 *
	 * @author lxp 20170613
	 * @param \Illuminate\Http\Request $request
	 * @param Closure $next
	 * @param null $guard
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		if (!Gate::allows('priv')) {
			if ($request->ajax() || $request->wantsJson()) {
				return response('Unallowed.', 401);
			} else {
				return response('Unallowed.')->header('Content-Type', 'text/plain');
			}
		}

		return $next($request);
	}
}
