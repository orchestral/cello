<?php

/*
|--------------------------------------------------------------------------
| Cello Routes
|--------------------------------------------------------------------------
|
| Define basic routing for Cello CMS.
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

/*
|--------------------------------------------------------------------------
| Cello Filters
|--------------------------------------------------------------------------
|
| Define basic routing for Cello CMS.
|
*/

Route::filter('cello::manage-pages', function ()
{
	// Redirect the user to login page if user is not logged in.
	if ( ! Hybrid\Acl::make('cello')->can('manage-pages')) 
	{
		$m = Orchestra\Messages::make('error', __('orchestra::response.credential.unauthorized'));

		return Redirect::to(handles('orchestra::resources/cello'))
				->with('message', $m->serialize());
	}
});