<?php

namespace App\Http\Controllers;

use App\Dao\UploadedFileDao;

/**
 * Ueditor控制器
 *
 * @package App\Http\Controllers
 */
class UeditorController extends Controller
{

	/**
	 * 取得配置
	 *
	 * @author lxp 20170302
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function config()
	{
		return response()->json(config('ueditor'));
	}

	/**
	 * 上传图片
	 *
	 * @author lxp 20170303
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function uploadimage()
	{
		// 取得上传文件字段名
		$fileField = config('ueditor')['imageFieldName'];
		// 上传文件类型
		$fileType = request('filetype', '');
		// 上传文件对应条目id
		$itemId = request('itemid', 0);

		// 上传并保存文件
		$fileReturn = UploadedFileDao::saveFile($fileField, $fileType, $itemId);

		if ($fileReturn['status']) {
			$fileObj = $fileReturn['data'];

			// 处理返回数据
			$fileData = [
				'state' => 'SUCCESS',
				'url' => get_file_url($fileObj->file_path . '/' . $fileObj->file_name) . '?f' . $fileObj->file_id,
				'title' => $fileObj->file_name,
				'original' => $fileObj->file_oldname,
				'type' => $fileObj->file_mime,
				'size' => $fileObj->file_size
			];
			return response()->json($fileData);
		} else {
			// 返回错误信息
			return response()->json(['state' => $fileReturn['data']]);
		}
	}

	/**
	 * 上传视频，"type_key"默认拼接"_VIDEO"
	 *
	 * @author lxp 20171012
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function uploadvideo()
	{
		if (request('filetype')) {
			request()->offsetSet('filetype', request('filetype') . '_VIDEO');
		}
		return $this->uploadimage();
	}

	/**
	 * 上传文件，"type_key"默认拼接"_FILE"
	 *
	 * @author lxp 20171012
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function uploadfile()
	{
		if (request('filetype')) {
			request()->offsetSet('filetype', request('filetype') . '_FILE');
		}
		return $this->uploadimage();
	}

}
