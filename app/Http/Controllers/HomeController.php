<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{

	public function __construct()
	{

	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('home');
	}

	public function welcome()
	{
		return view('welcome');
	}
}
