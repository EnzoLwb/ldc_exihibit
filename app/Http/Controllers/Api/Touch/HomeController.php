<?php

namespace App\Http\Controllers\Touch;

use App\Http\Controllers\Api\HomeController AS BaseHomeController;

class HomeController extends BaseHomeController
{

	public function __construct()
	{
		parent::_init();
	}

	public function index()
	{
		return response('Hello World Touch!');
	}
}
