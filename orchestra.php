<?php

Event::listen('orchestra.started', function ()
{
	$cello = Orchestra\Resources::make('cello', array(
		'name' => 'Cello CMS',
		'uses' => 'cello::home',
	));

	$cello->pages = 'cello::pages';

	$asset = Asset::container('orchestra.backend');
	$asset->script('redactor', 'bundles/cello/vendor/redactor/redactor.js', array('jquery', 'bootstrap'));
	$asset->script('cello', 'bundles/cello/js/cello.js', array('redactor'));
	$asset->style('redactor', 'bundles/cello/vendor/redactor/css/redactor.css', array('bootstrap'));
});