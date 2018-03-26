<?php

namespace App\Dao;

use App\Models\BaseMdl;

/**
 * Class MenuDao
 *
 * @author lxp 20180123
 * @package App\Dao
 */
class MenuDao extends BaseMdl
{
	/**
	 * 菜单及权限配置
	 *
	 * 最大支持三级菜单
	 * 每个菜单项要包括：
	 * text 名称
	 * priv 权限名称
	 *        例：控制器路径为 App/Http/Controllers/User/UsersController.php，则权限名称为 user-users
	 *           如果要对应方法，则用冒号拼接，user-users:getlist
	 *           对应多个方法（目前没有实现验证），user-users:getlist|getedit|postsave
	 *        如果不对应具体控制器，名称则随意，但不能重复
	 *
	 * url 链接（可选）
	 * nodes 子菜单（可选）
	 * icon 图标（可选）
	 *
	 * @author lxp 20180123
	 * @return array
	 */
	public static function get_admin_menu()
	{
		return [
			[
				'text' => '主页',
				'priv' => 'home',
				'url' => '/welcome'
			],
			[
				'text' => '设置',
				'priv' => 'setting',
				'icon' => 'fa fa-cog',
				'nodes' => [
					[
						'text' => '网站设置',
						'url' => route('admin.setting.basesetting'),
						'priv' => 'admin-setting-basesetting'
					],
					[
						'text' => '系统日志',
						'url' => route('admin.setting.systemlog'),
						'priv' => 'admin-setting-systemlog'
					]
				]
			],
			[
				'text' => '用户',
				'priv' => 'user',
				'nodes' => [
					[
						'text' => '用户管理',
						'url' => route('admin.user.users'),
						'priv' => 'admin-user-users'
					],
					[
						'text' => '管理员管理',
						'url' => route('admin.setting.adminusers'),
						'priv' => 'admin-setting-adminusers'
					],
					[
						'text' => '用户组管理',
						'url' => route('admin.setting.admingroup'),
						'priv' => 'admin-setting-admingroup'
					]
				]
			],
			[
				'text' => '文件管理',
				'priv' => 'file',
				'nodes' => [
					[
						'text' => '文件列表',
						'url' => '/admin/file/file',
						'priv' => 'admin-file-file'
					],
					[
						'text' => '上传图片',
						'url' => '/admin/file/file/upload',
						'priv' => 'admin-file-file:upload',
					],
					[
						'text' => '上传大文件',
						'url' => '/admin/file/file/multiupload',
						'priv' => 'admin-file-file:multiupload'
					],
					[
						'text' => '资源上传',
						'url' => '/admin/file/file/upload_resource',
						'priv' => 'admin-file-file:multiupload'
					]
				]
			],
			[
				'text' => '文章管理',
				'priv' => 'article',
				'nodes' => [
					[
						'text' => '文章列表',
						'url' => '/admin/article/article',
						'priv' => 'admin-article-article'
					],
					[
						'text' => '文章分类',
						'url' => '/admin/article/acategory',
						'priv' => 'admin-article-acategory'
					],
					[
						'text' => '评论列表',
						'url' => '/admin/article/comment',
						'priv' => 'admin-article-comment'
					]
				]
			]
		];
	}
}
