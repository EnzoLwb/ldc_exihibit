<?php

namespace App\Http\Controllers\Admin;

use App\Dao\UploadedFileDao;

/**
 * 通用Ajax上传控制器
 *
 * @package App\Http\Controllers
 */
class UploadController extends BaseAdminController
{

	/**
	 * webuploader上传图片
	 *
	 * @author lxp 20170302
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function uploadimg()
	{
		$filefield = 'file';
		$typeKey = request('type_key', 'FT_COMMON');
		$item_id = request('item_id', 0);

		$r = UploadedFileDao::saveFile($filefield, $typeKey, $item_id);
		if ($r['status']) {
			$fileObj = $r['data'];

			return $this->successData([
				'file_path' => $fileObj->file_path . '/' . $fileObj->file_name,
				'file_id' => $fileObj->file_id,
				'file_oldname' => $fileObj->file_oldname
			]);
		} else {
			return $this->error($r['data']);
		}
	}
}
