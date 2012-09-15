<?php

Event::listen('orchestra.started', function ()
{
	$cello = Orchestra\Resources::make('cello', array(
		'name' => 'Cello CMS',
		'uses' => 'cello::home',
	));
	$cello->blogs = 'cello::blogs';
	$cello->pages = 'cello::pages';
});