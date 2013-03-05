<?php

use Orchestra\Site,
	Orchestra\View;

class Cello_Api_Home_Controller extends Controller {

	/**
	 * Use Restful verb.
	 *
	 * @var boolean
	 */
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
		Site::set('title', 'Cello CMS');

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
		Site::set('title', 'Cello CMS Help');
		
		return View::make("cello::api.helps.{$page}");
	}
}
