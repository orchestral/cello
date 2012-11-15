<?php

use Cello\Model\Page,
	Orchestra\View;

class Cello_Cms_Controller extends Controller {
	
	/**
	 * Get Cello default homepage
	 *
	 * GET (:bundle)
	 *
	 * @access public
	 * @return Response
	 */
	public function action_home()
	{
		$slug = Config::get('cello::cello.default_page');
		
		return $this->action_page($slug);
	}
	
	/**
	 * Get a page from Cello
	 *
	 * GET (:bundle)/(:slug)
	 * 
	 * @access public
	 * @param  string   $slug
	 * @return Response
	 */
	public function action_page($slug = null)
	{
		$page = Page::where_slug($slug)->first();
		
		// page not found, 404.
		if (is_null($page)) return Response::error('404');

		return View::make("cello::page", compact('page', 'slug'));
	}
}