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
		switch (true)
		{
			case is_null($page) :
				// pass through
			case $page->status === Page::STATUS_DELETED :
				// pass through
			case ($page->status === Page::STATUS_DRAFT and is_null(Input::get('preview'))) :
				// pass through
			case ($page->status === Page::STATUS_PRIVATE and Auth::guest()) :
				return Response::error('404');
				break;
		}

		$data = compact('page', 'slug');
		
		View::share('_title_', $page->title);

		if (View::exists("cello::page.{$slug}"))
		{
			return View::make("cello::page.{$slug}", $data);
		}

		return View::make("cello::page", $data);
	}
}