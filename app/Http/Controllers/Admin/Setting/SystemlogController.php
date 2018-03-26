<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\BaseAdminController;
use Psy\VarDumper\Dumper;

/**
 * 系统日志控制器
 *
 * @package App\Http\Controllers\Admin\Setting
 */
class SystemlogController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$logpath = storage_path('logs');
		$dirhandler = opendir($logpath);
		$basedirlist = [];
		while (($dir = readdir($dirhandler)) !== false) {
			if ($dir != '..' && $dir != '.') {
				$dirpath = $logpath . '/' . $dir;
				if (is_dir($dirpath)) {
					array_push($basedirlist, [
						'name' => $dir,
						'path' => $dirpath,
						'type' => 'dir'
					]);
				} elseif (file_exists($dirpath) && pathinfo($dirpath)['extension'] == 'log') {
					array_push($basedirlist, [
						'name' => $dir,
						'path' => $dirpath,
						'type' => 'file'
					]);
				}
			}
		}
		array_multisort(array_column($basedirlist, 'name'), SORT_ASC, $basedirlist);

		return view('admin.setting.systemlog', ['dirlist' => $basedirlist]);
	}

	public function getdir()
	{
		$path = request('path');
		$list = [];
		if (is_dir($path)) {
			$dirhandler = opendir($path);
			while (($dir = readdir($dirhandler)) !== false) {
				if ($dir != '..' && $dir != '.') {
					$dirpath = $path . '/' . $dir;
					if (is_dir($dirpath)) {
						array_push($list, [
							'name' => $dir,
							'path' => $dirpath,
							'type' => 'dir'
						]);
					} elseif (file_exists($dirpath) && pathinfo($dirpath)['extension'] == 'log') {
						array_push($list, [
							'name' => $dir,
							'path' => $dirpath,
							'type' => 'file'
						]);
					}
				}
			}
		}
		array_multisort(array_column($list, 'name'), SORT_ASC, $list);

		return response()->json($list);
	}

	public function view()
	{
		$filepath = request('path');
		if (!file_exists($filepath)) {
			return $this->error('文件不存在');
		}

		$filecontents = [];
		$fp = fopen($filepath, 'r');
		while (!feof($fp)) {
			$filecontents[] = trim(fgets($fp));
		}
		fclose($fp);

		if ($filecontents[0] && is_json($filecontents[0])) {
			$logdata = [];
			foreach ($filecontents as $v) {
				if ($v) {
					$logdata[] = (new \Illuminate\Support\Debug\Dumper())->dump(json_decode($v));
				}
			}
			return;
		} else {
			return view('admin.setting.systemlog_view', [
				'filepath' => $filepath,
				'filecontents' => $filecontents,
			]);
		}
	}
}