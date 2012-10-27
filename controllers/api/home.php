<?php

use Orchestra\View;

class Cello_Api_Home_Controller extends Controller
{
	public $restful = true;
	
	public function get_index()
	{
		return View::make('cello::api.home');
	}

	public function get_help($page = 'index')
	{
		return View::make("cello::api.helps.{$page}");
	}
}