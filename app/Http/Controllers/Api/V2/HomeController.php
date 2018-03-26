<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Api\Controller;

class HomeController extends Controller
{

	public function __construct()
	{
		parent::_init();
	}

	public function index()
	{
		return response('Hello World V2!');
	}
}
