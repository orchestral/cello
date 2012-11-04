<?php

use Cello\Model\Page,
	Orchestra\View;

class Cello_Pages_Controller extends Controller
{
	public $restful = true;
	
	public function get_index($slug)
	{
		$page = Page::where_slug($slug)->first();
		
		// page not found, 404.
		if (is_null($page)) return Response::error('404');

		return View::make('cello::page', compact('page'));
	}
}