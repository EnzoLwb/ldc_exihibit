<?php

namespace App\Http\Controllers\Api\V2\Touch;

use App\Http\Controllers\Api\V2\HomeController AS BaseHomeController;

class HomeController extends BaseHomeController
{
	public function __construct()
	{
		parent::_init();
	}

	public function index()
	{
		return response('Hello World Touch V2!');
	}
}
