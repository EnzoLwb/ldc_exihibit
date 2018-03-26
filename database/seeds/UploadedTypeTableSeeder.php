<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UploadedTypeTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('uploaded_type')->insert([
			'type_key' => 'FT_COMMON',
			'path' => 'common',
			'desc' => '通用/测试',
			'allow_size' => 0
		]);
		DB::table('uploaded_type')->insert([
			[
				'type_key' => 'FT_AVATAR',
				'path' => 'avatar',
				'desc' => '用户头像',
				'allow_type' => 'gif|jpg|jpeg|png',
				'allow_size' => 1024 * 1024 * 2,
				'allow_num' => 1
			],
			[
				'type_key' => 'FT_ARTICLE_DESC',
				'path' => 'article_content',
				'desc' => '文章内容图片',
				'allow_type' => 'gif|jpg|jpeg|png',
				'allow_size' => 1024 * 1024 * 2,
				'allow_num' => 1
			],
			[
				'type_key' => 'FT_ARTICLE_DESC_FILE',
				'path' => 'article_content_file',
				'desc' => '文章内容文件(ueditor)',
				'allow_type' => '',
				'allow_size' => 1024 * 1024 * 5,
				'allow_num' => 1
			],
			[
				'type_key' => 'FT_ARTICLE_DESC_VIDEO',
				'path' => 'article_content_video',
				'desc' => '文章内容视频(ueditor)',
				'allow_type' => '',
				'allow_size' => 1024 * 1024 * 20,
				'allow_num' => 1
			],
			[
				'type_key' => 'FT_ARTICLE_IMG',
				'path' => 'article_img',
				'desc' => '文章头图',
				'allow_type' => 'gif|jpg|jpeg|png',
				'allow_size' => 1024 * 1024 * 2,
				'allow_num' => 1
			],
			[
				'type_key' => 'FT_ARTICLE_CATE',
				'path' => 'article_cate',
				'desc' => '文章分类',
				'allow_type' => 'gif|jpg|jpeg|png',
				'allow_size' => 1024 * 1024 * 2,
				'allow_num' => 1
			],
			[
				'type_key' => 'FT_ONE_RESOURCE',
				'path' => 'resource',
				'desc' => '单图片上传',
				'allow_type' => 'gif|jpg|jpeg|png',
				'allow_size' => 1024 * 1024 * 2,
				'allow_num' => 1
			],
			[
				'type_key' => 'FT_MORE_RESOURCE',
				'path' => 'resource',
				'desc' => '多图片上传',
				'allow_type' => 'gif|jpg|jpeg|png',
				'allow_size' => 1024 * 1024 * 2,
				'allow_num' => 5
			],
			[
				'type_key' => 'FT_ONE_MP3',
				'path' => 'mp3',
				'desc' => '音频上传',
				'allow_type' => 'mp3',
				'allow_size' => 1024 * 1024 * 20,
				'allow_num' => 1
			]
		]);
	}
}
