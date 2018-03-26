<?php
/**
 * composer require workerman/gateway-worker
 *
 * run with command
 * php workerman.php restart
 *
 * 后台运行
 * php workerman.php restart 1>/home/www/wwwroot/dmjz/storage/logs/workerman_output.log 2>&1 &
 *
 * 客户端连接测试
 * curl -v telnet://127.0.0.1:9100
 *
 * @author lxp 20170126
 */

ini_set('display_errors', 'on');

use Workerman\Worker;
use GatewayWorker\Register;
use GatewayWorker\Gateway;
use GatewayWorker\BusinessWorker;
use GatewayWorker\Lib\Gateway AS GatewayLib;
use Workerman\Lib\Timer;

// 检查扩展
if (!extension_loaded('pcntl')) {
	exit("Please install pcntl extension.\n");
}

if (!extension_loaded('posix')) {
	exit("Please install posix extension.\n");
}

// 初始化Laravel框架
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request = Illuminate\Http\Request::capture());

/**
 * 相关业务逻辑处理
 *
 * @author lxp
 */
class Events
{
	/**
	 * 当客户端连接时触发
	 *
	 * @param int $client_id 连接id
	 */
	public static function onConnect($client_id)
	{
		echo '[' . date('Y-m-d H:i:s') . '] ' . $_SERVER['REMOTE_ADDR'] . ':' . $_SERVER['REMOTE_PORT'] . " connected ...\n";
	}

	/**
	 * 当客户端发来消息时触发
	 *
	 * @param int $client_id 连接id
	 * @param mixed $message 具体消息
	 */
	public static function onMessage($client_id, $message)
	{
	}

	/**
	 * 当用户断开连接时触发
	 *
	 * @param int $client_id 连接id
	 */
	public static function onClose($client_id)
	{
		echo '[' . date('Y-m-d H:i:s') . '] [' . $client_id . '] ' . $_SERVER['REMOTE_ADDR'] . ':' . $_SERVER['REMOTE_PORT'] . " disconnected\n";
	}

	/**
	 * onWorkerStop
	 *
	 * @author lxp
	 * @param $businessWorker
	 */
	public static function onWorkerStop($businessWorker)
	{
	}
}

$registerIP = env('WM_REGISTER_IP', '127.0.0.1');
$registerPort = env('WM_REGISTER_PORT', '1238');
$gatewayPort = env('WM_GATEWAY_PORT', '9100');

// register 服务必须是text协议
$register = new Register("text://0.0.0.0:{$registerPort}");

// gateway 进程，这里使用Text协议，可以用telnet测试
$gateway = new Gateway("tcp://0.0.0.0:{$gatewayPort}");
// gateway名称，status方便查看
$gateway->name = 'DM_Gateway';
// gateway进程数
$gateway->count = 4;
// gateway起始端口
$gateway->startPort = env('WM_GATEWAY_STARTPORT', 3000);
// 服务注册地址
$gateway->registerAddress = "$registerIP:$registerPort";
// 心跳间隔
//$gateway->pingInterval = 10;
// 心跳数据
//$gateway->pingData = '{"type":"ping"}';

// bussinessWorker 进程
$worker = new BusinessWorker();
// worker名称
$worker->name = 'DM_BusinessWorker';
// bussinessWorker进程数量
$worker->count = 4;
// 服务注册地址
$worker->registerAddress = "$registerIP:$registerPort";

// Workerman运行日志
Worker::$logFile = __DIR__ . '/storage/logs/workerman.log';
// 运行所有服务
Worker::runAll();
