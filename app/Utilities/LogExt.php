<?php

namespace App\Utilities;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Redis;

/**
 * 日志方法
 *
 * @author lxp 20151219
 */
class LogExt
{

	const END_STR = '********************************************************************';
	private $logObj;
	/**
	 * 允许的错误等级
	 */
	private $logLevelAllow = [
		'info',
		// 感兴趣的事件，比如登录、退出
		'debug',
		// 详细的调试信息
		'notice',
		// 普通但值得注意的事件
		'warning',
		// 警告但不是错误，比如使用了被废弃的API
		'error',
		// 运行时错误，不需要立即处理但需要被记录和监控
		'alert',
		// 需要立即采取行动的问题，比如整站宕掉，数据库异常等，这种状况应该通过短信提醒
		'critical',
		// 严重问题，比如：应用组件无效，意料之外的异常
		'emergency'
		// 紧急状况，比如系统挂掉
	];

	/**
	 * 默认错误等级
	 */
	private $logLevel = 'info';
	private $redisLogKey;
	// 日志内容体
	private $logBody = [];

	public function __construct()
	{
		return $this;
	}

	/**
	 * 初始化monolog和redis
	 *
	 * @author lxp 20170615
	 * @param string $logTitle 日志标题，用于文件名或key
	 * @param string $logLevel 错误等级
	 * @return $this
	 */
	public function init($logTitle, $logLevel = 'info')
	{
		$this->logObj = new Logger($logTitle);
		// 创建0777权限的目录，兼容root和www用户
		$path_dir = storage_path() . '/logs/' . date('Y-m', time()) . '/';
		m_mkdir($path_dir);
		$path_dir .= date('d', time()) . '/';
		m_mkdir($path_dir);
		// 拼接日志文件路径
		$path = $path_dir . $logTitle . '.log';
		// 初始化日志文件流，权限0777
		$this->logObj->pushHandler($handler = new StreamHandler($path, Logger::DEBUG, true, 0777));
		$handler->setFormatter(new LineFormatter("%context%\n", null, true, true));
		if ($logLevel && in_array($logLevel, $this->logLevelAllow)) {
			$this->logLevel = $logLevel;
		}

		if (env('REDIS_LOG', false)) {
			Redis::select(env('REDIS_DBNUM_DEFAULT'));
			$this->redisLogKey = 'log:' . $logTitle . ':__' . date('Ymd');
		}

		$this->logBody['time'] = date('Y-m-d H:i:s');

		return $this;
	}

	/**
	 * 缓冲日志
	 *
	 * @author lxp 20180224
	 * @param string $logkey 日志key
	 * @param mixed $logvalue 日志值，字符串或数组
	 */
	public function logbuffer($logkey, $logvalue)
	{
		if (!isset($this->logBody[$logkey])) {
			$this->logBody[$logkey] = $logvalue;
		}
	}

	/**
	 * 将缓冲中的日志写入文件
	 *
	 * @author lxp 20180224
	 */
	public function logend()
	{
		// 记录基本请求参数
		$this->logBody['baseinfo'] = [
			'serverip' => request()->server('SERVER_ADDR'),
			'clentip' => request()->ip(),
			'useragent' => request()->userAgent(),
			'request_uri' => request()->server('REQUEST_URI'),
			'request_url' => request()->fullUrl(),
			'http_referer' => request()->server('HTTP_REFERER'),
			'request' => request()->all()
		];

		$this->logObj->{$this->logLevel}('', $this->logBody);
	}

	/**
	 * 处理redis日志格式
	 *
	 * @param string $message
	 * @param array $data
	 */
	private function logRedis($message, $data = [])
	{
		if (env('REDIS_LOG', false)) {
			if (!empty($data)) {
				$message = $message . ' ' . json_encode($data);
			}

			list($usec, $sec) = explode(" ", microtime());

			$redisMessage = [
				date('Y-m-d H:i:s') . ' ' . floor($usec * 1000),
				$this->logLevel . ': ' . $message
			];
			Redis::rPush($this->redisLogKey, json_encode($redisMessage));
		}
	}
}
