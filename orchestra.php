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
					$pages = Cello\Model\Page::where_not_in('status', array(
						Cello\Model\Page::STATUS_DRAFT,
						Cello\Model\Page::STATUS_DELETED
					))->get();

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
