<?php
use \Config;

Event::listen('orchestra.started', function ()
{
	$cello = Orchestra\Resources::make('cello', array(
		'name' => 'Cello CMS',
		'uses' => 'cello::home',
	));

	$cello->pages = 'cello::pages';
});

Orchestra\Extension\Config::map('cello', array(
	'remove_handle'       => 'cello::api.settings.remove_handle'
));

Event::listen('orchestra.started: backend', function() 
{
	$asset = Asset::container('orchestra.backend');
	$asset->script('redactor', 'bundles/cello/vendor/redactor/redactor.js', array('jquery', 'bootstrap'));
	$asset->script('cello', 'bundles/cello/js/cello.js', array('redactor'));
	$asset->style('redactor', 'bundles/cello/vendor/redactor/css/redactor.css', array('bootstrap'));
});

Event::listen('orchestra.form: extension.cello', function ($config, $form)
{
	$form->extend(function ($form) use ($config)
	{
		$form->fieldset('URL Handling', function ($fieldset) use ($config)
		{
			$fieldset->control('input:checkbox', 'remove_handle', function($control) use ($config) {
				$control->label = 'Remove handle from URL';
				if ($config->attributes['remove_handle'] == 'on') {
					$control->checked = true;
				}
			});
		});
	});
});