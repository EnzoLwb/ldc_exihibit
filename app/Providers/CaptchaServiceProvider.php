<?php
namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use App\Utilities\Captcha\Securimage;

/**
 * Class CaptchaServiceProvider
 *
 * @author lxp
 */
class CaptchaServiceProvider extends ServiceProvider {
	protected $defer = true;

	public function boot() {

	}

	public function register() {
		$this->app->bind('captcha', function ($app) {
			return new Securimage(app('config')->get('captcha'));
		});
	}

	public function provides() {
		return [
			'captcha'
		];
	}
}
