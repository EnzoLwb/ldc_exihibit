<?php

namespace App\Http\Middleware;

use Closure;

class AfterMiddleware
{
	/**
	 * 后置中间件，运行于处理请求之后
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$response = $next($request);

		// 保存历史url
		set_session_url();

		return $response;
	}
}
