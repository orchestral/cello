<?php
use \Config;

Event::listen('orchestra.started', function ()
{
	$cello = Orchestra\Resources::make('cello', array(
		'name' => 'Cello CMS',
		'uses' => 'cello::api.home',
	));

	$cello->pages = 'cello::api.pages';
});

Event::listen('orchestra.started: backend', function() 
{
	$asset = Asset::container('orchestra.backend');
	$asset->script('redactor', 'bundles/cello/vendor/redactor/redactor.js', array('jquery', 'bootstrap'));
	$asset->script('cello', 'bundles/cello/js/cello.js', array('redactor'));
	$asset->style('redactor', 'bundles/cello/vendor/redactor/css/redactor.css', array('bootstrap'));
});