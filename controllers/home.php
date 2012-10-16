<?php

class Cello_Home_Controller extends Controller
{
	public $restful = true;
	
	public function get_index()
	{
		return View::make('cello::home');
	}

	public function get_help($page = 'index')
	{
		return View::make("cello::helps.{$page}");
	}
}