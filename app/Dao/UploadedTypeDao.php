<?php

namespace App\Dao;

use App\Models\UploadedType;
use Illuminate\Support\Facades\Cache;

/**
 * 附件类型业务模型
 *
 * @author lxp 20160712
 */
class UploadedTypeDao extends UploadedType
{

	/**
	 * 取得附件上传类型的相关信息
	 *
	 * @author lxp 20160712
	 * @param string $type_key
	 * @return array
	 */
	public static function getFileType($type_key)
	{
		// 取得所有附件类型数据
		$uTypes = UploadedType::all()->keyBy('type_key')->toArray();

		if (isset($uTypes[$type_key])) {
			return $uTypes[$type_key];
		} else {
			return [];
		}
	}

}
