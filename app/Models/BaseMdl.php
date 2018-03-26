<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * 模型基类
 *
 * @author lxp 20170104
 * @package App\Models
 */
class BaseMdl extends Model {

	// 关闭Eloquent默认的 updated_at、created_at 两个字段
	public $timestamps = false;

	/**
	 * 覆写取当前模型表名称
	 * 例：类名称 CommonUserInfo 转化为表名称 common_user_info
	 *
	 * @author lxp 20170104
	 * @return mixed|string
	 */
	public function getTable() {
		if (isset($this->table)) {
			return $this->table;
		}

		return str_replace('\\', '', Str::snake((class_basename($this))));
	}
}
