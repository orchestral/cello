<?php
use \Config;

Route::any('(:bundle)/(:any?)', function ($page = '')
{
	return Controller::call('Cello::cms@index',array($page));
});

Event::listen('404', function()
{
	if (Config::get('cello::api.settings.remove_handle') == 'on') {
		$uri = Request::uri();
		if ($uri == '/') {
			$uri = '';
		}
		//make a normal response
		return Controller::call('Cello::cms@index',array($uri));
	}
	return Response::error('404');
});