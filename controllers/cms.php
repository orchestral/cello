<?php

use Cello\Model\Page,
	Orchestra\View;

class Cello_Cms_Controller extends Controller
{
	public function action_home()
	{
		$slug = Config::get('cello::cello.default_page');
		
		return $this->action_page($slug);
	}
	
	public function action_page($slug = null)
	{
		$page = Page::where_slug($slug)->first();
		
		// page not found, 404.
		if (is_null($page)) return Response::error('404');

		return View::make("cello::page", compact('page', 'slug'));
	}
}