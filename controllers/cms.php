<?php
use Cello\Model\Page;

class Cello_Cms_Controller extends Controller
{
	public $restful = true;
	
	public function get_index($slug)
	{
		$page = Page::where('slug','=',$slug)->first();
		if ($page === NULL) {
			//page not found, 404.
			return Response::error('404');
		}
		$data = array(
			'page'  => $page,
		);
		return View::make('cello::resources.cms', $data);
	}

}