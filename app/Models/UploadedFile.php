<?php
namespace App\Models;

/**
 * 上传文件模型
 *
 * @author lxp 20160624
 */
class UploadedFile extends BaseMdl
{
	protected $primaryKey = 'file_id';
	public $timestamps = true;

	// 不可被批量赋值的属性，反之其他的字段都可被批量赋值
	protected $guarded = [
		'file_id'
	];
}
