<?php

use Orchestra\View;

class Cello_Api_Home_Controller extends Controller {
	
	public $restful = true;
	
	/**
	 * Get welcome page
	 * 
	 * GET (orchestra)/resources/cello
	 *
	 * @access public
	 * @return Response
	 */
	public function get_index()
	{
		View::share('_title_', 'Cello CMS');
		
		return View::make('cello::api.home');
	}

	/**
	 * Get help page
	 *
	 * GET (orchestra)/resources/cello.help
	 *
	 * @access public
	 * @param  string   $page
	 * @return Response
	 */
	public function get_help($page = 'index')
	{
		return View::make("cello::api.helps.{$page}");
	}
}