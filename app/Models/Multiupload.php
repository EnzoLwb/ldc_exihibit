<?php
namespace App\Models;

/**
 * 分片上传文件模型
 *
 * @author lxp 20160704
 */
class Multiupload extends BaseMdl
{
	protected $primaryKey = 'id';
	public $timestamps = true;
	// 不可被批量赋值的属性，反之其他的字段都可被批量赋值
	protected $guarded = [
		'id'
	];

	/**
	 * 与文件碎片为一对多关系
	 *
	 * @author lxp
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function part()
	{
		return $this->hasMany('App\Models\MultiuploadPart', 'fid');
	}
}
