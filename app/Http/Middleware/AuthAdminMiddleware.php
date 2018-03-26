<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthAdminMiddleware
{

	/**
	 * Handle an incoming request.
	 *
	 * @author lxp
	 * @param \Illuminate\Http\Request $request
	 * @param Closure $next
	 * @param null $guard
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		if (Auth::guard()->guest()) {
			if ($request->ajax() || $request->wantsJson()) {
				return response('Unauthorized.', 401);
			} else {
				return response("<script>window.top.location.href='" . route('admin.login') . "';</script>");
			}
		}

		return $next($request);
	}
}
