<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Utilities\Tree;

/**
 *
 * @author lxp 20160118
 */
class TreeServiceProvider extends ServiceProvider {

	/**
	 * 延迟加载
	 */
	protected $defer = true;

	public function register() {
		$this->app->bind('tree', function ($app) {
			return new Tree();
		});
	}

	public function provides() {
		return [
			'tree'
		];
	}
}
