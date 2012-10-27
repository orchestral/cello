<?php

use Cello\Model\Page,
	Orchestra\View;

class Cello_Pages_Controller extends Controller
{
	public $restful = true;
	
	public function get_index($slug)
	{
		$page = Page::where_slug($slug)->first();
		
		if ($page === NULL) 
		{
			//page not found, 404.
			return Response::error('404');
		}

		$data = compact('page');
		
		return View::make('cello::page', $data);
	}
}