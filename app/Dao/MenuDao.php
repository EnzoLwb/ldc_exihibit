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
                'text' => '首页',
                'priv' => 'admin.home',
                'icon' => 'glyphicon glyphicon-eur',
                'url'=>route('admin.welcome'),
                'nodes'=>[]
            ],
			[
				'text' => '藏品征集',
				'priv' => 'exhibitcollect',
				'icon' => 'glyphicon glyphicon-eur',
				'nodes' => [
					[
						'text' => '征集申请',
						'url' => route('admin.exhibitcollect.apply'),
						'priv' => 'admin-exhibitcollect-exhibit'
					],
					[
						'text' => '接收入馆',
						'url' => route('admin.exhibitcollect.getin'),
						'priv' => 'admin-exhibitcollect-exhibit'
					]
				]
			],
            [
                'text' => '申请管理',
                'priv' => 'applymanage',
                'icon' => 'fa fa-cog',
                'nodes' => [
                    [
                        'text' => '申请列表',
                        'url' => route('admin.applymanage.export_collect_apply'),
                        'priv' => 'admin-applymanage-apply'
                    ]
                ]
            ],
            [
                'text' => '录入鉴定结果',
                'priv' => 'recordidentify',
                'icon' => 'fa fa-cog',
                'nodes' => [
                    [
                        'text' => '鉴定列表',
                        'url' => route('admin.recordidentify.recordidentify'),
                        'priv' => 'admin-recordidentify-recordidentify'
                    ]
                ]
            ],
			[
				'text' => '藏品鉴定',
				'priv' => 'exhibitidentify',
				'icon' => 'fa fa-cog',
				'nodes' => [
					[
						'text' => '鉴定申请',
						'url' => route('admin.exhibitidentify.exhibit'),
						'priv' => 'admin-exhibitidentify-exhibit'
					],
					[
						'text' => '鉴定管理',
						'url' => route('admin.exhibitidentify.manage'),
						'priv' => 'admin-exhibitidentify-manage'
					],
					[
						'text' => '鉴定专家管理',
						'url' => route('admin.exhibitidentify.expert'),
						'priv' => 'admin-exhibitidentify-expert'
					]
				]
			],
			[
				'text' => '信息登记',
				'priv' => 'inforegister',
				'icon' => 'fa fa-cog',
				'nodes' => [
					[
						'text' => '馆藏文物管理',
						'url' => route('admin.inforegister.exhibitmanage'),
						'priv' => 'admin-inforegister-index'
					],
					[
						'text' => '其他文物信息登记',
						'url' => route('admin.inforegister.subsidiary'),
						'priv' => 'admin-inforegister-subsidiary'
					]
				]
			],
			[
				'text' => '账目管理',
				'priv' => 'accountmanage',
				'icon' => 'fa fa-cog',
				'nodes' => [
					[
						'text' => '总账',
						'url' => route('admin.accountmanage.sumaccount'),
						'priv' => 'admin-accountmanage-index'
					],
					[
						'text' => '辅助账',
						'url' => route('admin.accountmanage.subsidiary'),
						'priv' => 'admin-accountmanage-subsidiary'
					]
				]
			],

			[
				'text' => '藏品保管',
				'priv' => 'exhibitmanage',
				'icon' => 'fa fa-cog',
				'nodes' => [
					[
						'text' => '移库管理',
						'url' => route('admin.exhibitmanage.storageroom'),
						'priv' => 'admin-exhibitmanage-index'
					],
					[
						'text' => '消毒登记',
						'url' => route('admin.exhibitmanage.disinfection'),
						'priv' => 'admin-exhibitmanage-disinfection'
					],
					[
						'text' => '入库管理',
						'url' => route('admin.exhibitmanage.instorageroom'),
						'priv' => 'admin-exhibitmanage-instoragemanage'
					],
					[
						'text' => '藏品出库',
						'url' => route('admin.exhibitmanage.outstorageroom.oustorageapply'),
						'priv' => 'admin-exhibitmanage-outstorageroom',
						'nodes' => [
							[
								'text' => '出库申请',
								'url' => route('admin.exhibitmanage.outstorageroom.oustorageapply'),
								'priv' => 'admin-exhibitmanage-outstorageroom-oustorageapply'
							],
							[
								'text' => '藏品出库',
								'url' => route('admin.exhibitmanage.outstorageroom.exhibitout'),
								'priv' => 'admin-exhibitmanage-storageroom-exhibitout'
							],
						]
					],
					[
						'text' => '藏品回库',
						'url' => route('admin.exhibitmanage.exhibitbackroom'),
						'priv' => 'admin-exhibitmanage-exhibitbackroom'
					],
                    /**
					[
						'text' => '移库管理',
						'url' => route('admin.exhibitmanage.transfer'),
						'priv' => 'admin-exhibitmanage-transfer'
					],**/
					[
						'text' => '事故登记',
						'url' => route('admin.exhibitmanage.accidentregistration'),
						'priv' => 'admin-exhibitmanage-accidentregistration'
					],
				]
			],
			[
				'text' => '库房日常管理',
				'priv' => 'storageroommanage',
				'icon' => 'fa fa-cog',
				'nodes' => [
					[
						'text' => '人员出入管理',
						'url' => route('admin.storageroommanage.peopleinoutmanage'),
						'priv' => 'admin-storageroommanage-peopleinoutmanage'
					],
					[
						'text' => '库房环境',
						'url' => route('admin.storageroommanage.roomenv'),
						'priv' => 'admin-storageroommanage-roomenv'
					],
					[
						'text' => '库房管理',
						'url' => route('admin.storageroommanage.roomstruct'),
						'priv' => 'admin-storageroommanage-roomstruct'
					],
					[
						'text' => '库房盘点',
						'url' => route('admin.storageroommanage.roomlist'),
						'priv' => 'admin-storageroommanage-roomlist'
					]
				]
			],
			[
				'text' => '藏品展览',
				'priv' => 'exhibitshow',
				'icon' => 'fa fa-cog',
				'nodes' => [
					[
						'text' => '展览申请',
						'url' => route('admin.exhibitshow.apply'),
						'priv' => 'admin-exhibitshow-apply'
					],
					[
						'text' => '展品展览',
						'url' => route('admin.exhibitshow.show'),
						'priv' => 'admin-exhibitshow-show'
					],
					[
						'text' => '展位管理',
						'url' => route('admin.exhibitshow.position'),
						'priv' => 'admin-exhibitshow-position'
					]

				]
			],
			//			[
			//				'text' => '复仿制管理',
			//				'priv' => 'copymanage',
			//				'icon' => 'fa fa-cog',
			//				'nodes' => [
			//					[
			//						'text' => '复仿制申请（本）',
			//						'url' => route('admin.copymanage.selfapply'),
			//						'priv' => 'admin-copymanage-selfapply'
			//					],
			//					[
			//						'text' => '复仿制申请（外）',
			//						'url' => route('admin.copymanage.otherapply'),
			//						'priv' => 'admin-copymanage-otherapply'
			//					],
			//					[
			//						'text' => '复仿制登记',
			//						'url' => route('admin.copymanage.register'),
			//						'priv' => 'admin-copymanage-register'
			//					]
			//
			//				]
			//			],
			[
				'text' => '藏品修复',
				'priv' => 'repaireexhibit',
				'icon' => 'fa fa-cog',
				'nodes' => [
					[
						'text' => '修复申请',
						'url' => route('admin.repaireexhibit.apply'),
						'priv' => 'admin-repaireexhibit-apply'
					],
					[
						'text' => '藏品修复',
						'url' => route('admin.repaireexhibit.repairin'),
						'priv' => 'admin-repaireexhibit-repairin'
					],
				]
			],
			[
				'text' => '藏品注销',
				'priv' => 'admin-exhibitlogout-exhibitlogout',
				'icon' => 'fa fa-cog',
				'url' => route('admin.exhibitlogout')
			],
			//			[
			//				'text' => '综合查询',
			//				'priv' => 'sumquery',
			//				'icon' => 'fa fa-cog',
			//				'nodes' => [
			//					[
			//						'text' => '藏品查询',
			//						'url' => route('admin.sumquery.exhibitquery'),
			//						'priv' => 'admin-sumquery-exhibitquery'
			//					],
			//					[
			//						'text' => '藏品查询(一普)',
			//						'url' => route('admin.sumquery.exhibitqueryfor'),
			//						'priv' => 'admin-sumquery-exhibitqueryfor'
			//					],
			//					[
			//						'text' => '授权查询',
			//						'url' => route('admin.sumquery.authorityquery'),
			//						'priv' => 'admin-sumquery-authorityquery'
			//					],
			//				]
			//			],
			[
				'text' => '数字资源管理',
				'priv' => 'digitalmanage',
				'icon' => 'fa fa-cog',
				'nodes' => [
					[
						'text' => '资源管理',
						'url' => route('admin.file.file'),
						'priv' => 'admin-file-file'
					],
					[
						'text' => '资源上传',
						'url' => route('admin.file.file.multiupload'),
						'priv' => 'admin-file-multiupload'
					]
				]
			],
			[
				'text' => '统计分析',
				'priv' => 'statics',
				'icon' => 'fa fa-cog',
				'nodes' => [
					[
						'text' => '鉴定统计',
						'url' => route('admin.statics.identify'),
						'priv' => 'admin-statics-identify'
					],
					[
						'text' => '修复统计',
						'url' => route('admin.statics.repaire'),
						'priv' => 'admin-statics-repaire'
					],
					[
						'text' => '复仿制统计',
						'url' => route('admin.statics.copy'),
						'priv' => 'admin-statics-copy'
					],
					[
						'text' => '藏品统计',
						'url' => route('admin.statics.exhibit'),
						'priv' => 'admin-statics-exhibit'
					],
				]
			],
			[
				'text' => '用户',
				'priv' => 'user',
				'nodes' => [
					//					[
					//						'text' => '用户管理',
					//						'url' => route('admin.user.users'),
					//						'priv' => 'admin-user-users'
					//					],
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
            /*
            [
                'text' => '通知管理',
                'priv' => 'notice',
                'icon' => 'fa fa-cog',
                'nodes' => [
                    [
                        'text' => '发布通知',
                        'url' => route('admin.notice.publis_notice'),
                        'priv' => 'admin-notice-index'
                    ],
                    [
                        'text' => '历史通知',
                        'url' => route('admin.notice.history_list'),
                        'priv' => 'admin-notice-index'
                    ]
                ]
            ],
            */
		];

		/*
		return [
			[
				'text' => '主页',
				'priv' => 'home',
				'url' => '/welcome'
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
		*/
	}
}
