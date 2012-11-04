<?php

/*
|--------------------------------------------------------------------------
| Cello Routes
|--------------------------------------------------------------------------
|
*/

Route::any('(:bundle)/(:any)?', function ($page = '')
{
	return Controller::call('cello::cms@page', array($page));
});

Route::any('(:bundle)', function ()
{
	// get default page route from configuration, this is configurable 
	// from Orchestra Administrator Interface.
	return Controller::call('cello::cms@home');
});