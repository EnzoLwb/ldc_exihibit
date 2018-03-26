<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ApiDoc extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'apidoc';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$controller_dir = app_path('Http/Controllers/Api');
		$output_dir = env('APIDOC_OUTPUT_DIR', '');

		$config = [];
		$config['name'] = env('APIDOC_NAME');
		$config['version'] = env('APIDOC_VERSION');
		$config['description'] = "请求时，请在Headers中添加 'Accept':'application/json'";
		$config['title'] = env('APIDOC_NAME');
		$config['sampleUrl'] = env('APIDOC_SAMPLE_URL');
		$config['jQueryAjaxSetup'] = ['headers' => ['Accept' => 'application/json']];
		// 生成apidoc.json文件
		file_put_contents($controller_dir . '/apidoc.json', json_encode($config));

		// 生成apidoc
		$command = "apidoc -i {$controller_dir} -o {$output_dir}";
		system($command);
	}
}
