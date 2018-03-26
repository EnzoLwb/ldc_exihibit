<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ReflectionException;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		\Illuminate\Auth\AuthenticationException::class,
		\Illuminate\Auth\Access\AuthorizationException::class,
		\Symfony\Component\HttpKernel\Exception\HttpException::class,
		\Illuminate\Database\Eloquent\ModelNotFoundException::class,
		\Illuminate\Session\TokenMismatchException::class,
		\Illuminate\Validation\ValidationException::class,
		ApiErrorException::class,
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception $exception
	 * @return void
	 */
	public function report(Exception $exception)
	{
		// 自定义系统错误日志
		try {
			if ($this->shouldReport($exception)) {
				$logObj = app('logext');
				$logObj->init('error', 'error');
				$logObj->logbuffer('errormsg', "[{$exception->getCode()}] {$exception->getMessage()}");
				$logObj->logbuffer('errorfile', "{$exception->getFile()}: line {$exception->getLine()}");
				$logObj->logend();
			}
		} catch (Exception $e) {
			parent::report($exception);
		}
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Exception $exception
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $exception)
	{
		if ($request->expectsJson()) {
			// 自定义报错页面
			if (!env('APP_DEBUG') && method_exists($exception, 'getStatusCode')) {
				$statusCode = $exception->getStatusCode();
				$first = substr($statusCode, 0, 1);
				if ($first == 4 || $first == 5) {
					return response_json($statusCode);
				}
			}

			// 处理firstOrFail
			if ($exception instanceof ModelNotFoundException) {
				return response_json(0, [], '数据不存在，请重试');
			}

			// API通用错误
			if ($exception instanceof ApiErrorException) {
				return response_json($exception->getCode(), [], $exception->getMessage());
			}

			// 空控制器
			if ($exception instanceof ReflectionException) {
				return response_json(404);
			}

			// 空方法调用
			if ($exception instanceof NotFoundHttpException) {
				return response_json(404);
			}
		}

		if ($exception instanceof TokenMismatchException) {
			// token 过期
			return abort(499);
		}

		return parent::render($request, $exception);
	}

	/**
	 * Convert an authentication exception into an unauthenticated response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Illuminate\Auth\AuthenticationException $exception
	 * @return \Illuminate\Http\Response
	 */
	protected function unauthenticated($request, AuthenticationException $exception)
	{
		// 请求时在Headers中添加 key:Accept value:application/json
		if ($request->expectsJson()) {
			return response_json(405, [], '登录已失效，请重新登录');
		}

		return redirect()->guest('login');
	}
}
