<?php

/*
|--------------------------------------------------------------------------
| Register Cello
|--------------------------------------------------------------------------
|
| Register Cello as Orchestra Resources.
|
*/

Event::listen('orchestra.started', function ()
{
	$cello = Orchestra\Resources::make('cello', array(
		'name' => 'Cello CMS',
		'uses' => 'cello::api.home',
	));

	$cello->pages = 'cello::api.pages';
});

Orchestra\Extension\Config::map('cello', array(
	'default_page' => 'cello::cello.default_page'
));

/*
|--------------------------------------------------------------------------
| Register Cello Assets for Backend
|--------------------------------------------------------------------------
|
| Append all Cello required assets for Orchestra Administrator Interface usage 
| mainly on Resources page.
|
*/

Event::listen('orchestra.started: backend', function() 
{
	$asset = Asset::container('orchestra.backend');

	$asset->script('redactor', 'bundles/cello/vendor/redactor/redactor.js', array('jquery', 'bootstrap'));
	$asset->script('cello', 'bundles/cello/js/cello.js', array('redactor'));
	$asset->style('redactor', 'bundles/cello/vendor/redactor/css/redactor.css', array('bootstrap'));
});

/*
|--------------------------------------------------------------------------
| Hook Cello Configuration
|--------------------------------------------------------------------------
|
| Allow Orchestra Extension Configuration page to configure Cello options.
|
*/

Event::listen('orchestra.form: extension.cello', function ($config, $form)
{
	$form->extend(function ($form) use ($config)
	{
		$form->fieldset('URL Handling', function ($fieldset) use ($config)
		{
			$fieldset->control('select', 'default_page', function($control) use ($config) 
			{
				$control->label   = 'Default Page';
				$control->options = function()
				{
					$data  = array();
					$pages = Cello\Model\Page::where_not_in('status', array(Cello\Model\Page::STATUS_DRAFT))->get();

					foreach ($pages as $page)
					{
						$data[$page->slug] = $page->title;
					}

					return $data;
				};
			});
		});
	});
});