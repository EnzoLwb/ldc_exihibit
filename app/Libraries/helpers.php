<?php
use Illuminate\Support\Facades\Route;

/**
 * 和业务相关的辅助方法
 */

if (!function_exists('cdn')) {

	/**
	 * 统一处理资源文件路径，方面以后切换cdn
	 *
	 * @author lxp 20160616
	 * @param $path
	 * @return string
	 */
	function cdn($path)
	{
		return asset($path);
	}
}

if (!function_exists('get_file_url')) {

	/**
	 * 统一处理附件url，方面以后切换cdn
	 *
	 * @author lxp 20160712
	 * @param string $filepath 文件相对路径
	 * @return string
	 */
	function get_file_url($filepath)
	{
		return url($filepath);
	}
}

if (!function_exists('set_session_url')) {

	/**
	 * 保存历史url
	 * session操作应在session中间件启用后调用
	 *
	 * @author lxp 20170111
	 */
	function set_session_url()
	{
		// 从session中取出历史url
		$mPreviousUrl = session('mPreviousUrl');
		$mPreviousUrl == null && $mPreviousUrl = [];

		// 取出当前控制器完整包路径
		if (!Route::getCurrentRoute()) {
			return;
		}
		$urlCacheKey = strtolower(Route::getCurrentRoute()->getActionName());
		// 取出当前完整url
		$urlCacheVal = request()->fullUrl();
		// 去除相同的历史url，添加新记录
		unset($mPreviousUrl[$urlCacheKey]);
		$mPreviousUrl[$urlCacheKey] = $urlCacheVal;

		// 最多保留20条最近的历史url
		$mPreviousUrl = array_slice($mPreviousUrl, -20);
		// 存入session
		session(['mPreviousUrl' => $mPreviousUrl]);
	}

	/**
	 * 根据action取出历史url
	 * session操作应在session中间件启用后调用
	 *
	 * @author lxp 20170111
	 * @param string $action 方法名，例如：index
	 * @param string $controller 可传入自定义的包名，例如：App\Http\Controllers\Opt\Article
	 * @param string $defaultUrl 如没记录则跳转该url
	 * @return mixed|string
	 */
	function get_session_url($action, $controller = '', $defaultUrl = '')
	{
		// 从session中取出历史url
		$mPreviousUrl = session('mPreviousUrl');
		if ($mPreviousUrl != null) {
			// 取得当前完成包路径
			if ($controller == '') {
				$controllerPath = Route::getCurrentRoute()->getActionName();
				$controller = substr($controllerPath, 0, strpos($controllerPath, '@'));
			}
			// 拼接key
			$urlCacheKey = strtolower($controller . '@' . $action);
			if (isset($mPreviousUrl[$urlCacheKey])) {
				// 返回url
				return $mPreviousUrl[$urlCacheKey];
			}
		}
		// 没有记录则返回默认页
		return $defaultUrl;
	}
}

if (!function_exists('thumbs')) {

	/**
	 * 生成缩略图路径
	 *
	 * @author lxp 20170320
	 * @param string $file 图片路径
	 * @param int $width 宽度
	 * @param int $height 高度
	 * @param int $type 图片剪裁类型
	 *        1 原图
	 *        31 等比例缩放
	 *        32 缩放后填充
	 *        33 缩放后居中裁剪
	 *        34 左上角裁剪
	 *        35 右下角裁剪
	 *        36 固定尺寸缩放
	 * @return string
	 */
	function thumbs($file, $width, $height, $type = 32)
	{
		// 过滤文件路径中的域名
		$file = preg_replace('/http:\/\/[^\/]*/i', '', $file);
		$fileext = pathinfo($file, PATHINFO_EXTENSION);

		$fileMd5 = md5($file);
		$type = intval($type);

		if ($type == 1) {
			// 调用原图
			$thumbsUrl = env('IMG_THUMBS_DOMAIN') . $file;
		} else {
			$thumbsUrl = env('IMG_THUMBS_DOMAIN') . env('IMG_THUMBS_PATH') . '/thumbimg/' . $fileMd5[0] . '/' . $fileMd5[3] . '/' . $width . '/' . $height . '/' . $type . '/' . base64_encode($file) . '.auto.' . $fileext;
		}
		return $thumbsUrl;
	}
}

if (!function_exists('textfile_parse')) {

	/**
	 * 解析并替换文本中的图片url
	 *
	 * @author lxp 20170907
	 * @param string $content
	 * @return mixed
	 */
	function textfile_parse($content)
	{
		if (!$content || !is_string($content)) {
			return $content;
		}

		// 匹配附件ID
		preg_match_all('/src=[\'|"][^"\']+\?f([0-9]+)[^"\']*[\'|"]/i', $content, $result);
		if (is_array($result[1])) {
			$atta_array = array();
			foreach ($result[1] as $file_id) {
				// 取得附件信息
				$fileObj = \App\Models\UploadedFile::find($file_id);
				if (!is_null($fileObj)) {
					$fileurl = get_file_url($fileObj->file_path . '/' . $fileObj->file_name);
					$atta_array[] = 'src="' . $fileurl . '"';
				}
			}
			// 替换文本中附件url
			$content = str_replace($result[0], $atta_array, $content);
		}

		return $content;
	}
}

if (!function_exists('generate_sign')) {
	/**
	 * 微信支付生成签名
	 *
	 * @author lxp 20170914
	 * @param array $attributes
	 * @param $key
	 * @param string $encryptMethod
	 * @return string
	 */
	function generate_sign(array $attributes, $key, $encryptMethod = 'md5')
	{
		ksort($attributes);
		$attributes['key'] = $key;
		return strtoupper(call_user_func_array($encryptMethod, [urldecode(http_build_query($attributes))]));
	}
}

include_once 'helpers_api.php';