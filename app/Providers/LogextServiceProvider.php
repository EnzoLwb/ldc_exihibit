<?php
namespace App\Providers;

use App\Utilities\LogExt;
use Illuminate\Support\ServiceProvider;

class LogextServiceProvider extends ServiceProvider {

	public function register() {
		$this->app->bind('logext', function ($app) {
			return new LogExt();
		});
	}
}
