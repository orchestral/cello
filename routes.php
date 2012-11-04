<?php

/*
|--------------------------------------------------------------------------
| Cello Routes
|--------------------------------------------------------------------------
|
*/

Route::any('(:bundle)/(:any)?', function ($page = '')
{
	return Controller::call('cello::pages@index', array($page));
});

Route::any('(:bundle)', function ()
{
	// get default page route from configuration, this is configurable 
	// from Orchestra Administrator Interface.
	$page = Config::get('cello::cello.default_page');

	return Controller::call('cello::pages@index', array($page));
});