<?php
/**
 * 被动生成缩略图方法
 *
 * @author lxp 20170320
 */
require __DIR__ . '/../vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;

// 源文件相对根路径
define('RPATH_R', dirname(__file__));
// 缩略图相对根路径
define('RPATH_D', dirname(__file__));

$uri = $_SERVER['REQUEST_URI'];
if (preg_match("/(\d{2,4})\/(\d{2,4})\/(\d{1,2})\/([^\.]+)\.(?:auto)\.(?:jpg|gif|png|jpeg)/i", $uri, $path)) {
	// 原图相对物理地址
	$p = preg_replace('/http:\/\/[^\/]*/i', '', base64_decode($path[4]));
	$p = str_replace('//', '/', '/' . $p);
	// 缩放宽
	$w = intval($path[1]);
	// 缩放高
	$h = intval($path[2]);
	// 缩放类型
	$t = trim($path[3]);

	// 当源文件存在，切高度和宽度不都为0时才进行缩放或剪切
	if (file_exists(RPATH_R . $p) && ($w > 0 || $h > 0)) {
		// 缩略图存放目标位置
		$dest = RPATH_D . $uri;
		// 创建缩图组建实例
		$img = Image::make(RPATH_R . $p);
		// 根据缩放类型分别处理
		switch ($t) {
			case 31:
				// 按缩放比小的一边等比缩放
				$img->resize($w, $h, function ($constraint) {
					$constraint->aspectRatio();
				});
				break;
			case 32:
				// 按比例缩放后填充
				$img->resize($w, $h, function ($constraint) {
					$constraint->aspectRatio();
				})->resizeCanvas($w, $h);
				break;
			case 33:
				// 等比缩放后居中剪切
				$img->fit($w, $h);
				break;
			case 34:
				// 左上剪切
				$img->crop($w, $h, 0, 0);
				break;
			case 35:
				// 右下剪切
				$img->crop($w, $h, $img->width() - $w, $img->height() - $h);
				break;
			case 36:
				// 固定尺寸，图片可能变形
				$img->resize($w, $h);
				break;
			default:
				break;
		}
		// 如果缩略图目录不存在则创建
		if (!is_dir(dirname($dest))) {
			mkdir(dirname($dest), 0755, true);
		}
		// 生成缩略图并输出
		echo $img->save($dest)->response();
	}
}
