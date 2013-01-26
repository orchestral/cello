<?php

/*
|--------------------------------------------------------------------------
| Cello Library
|--------------------------------------------------------------------------
|
| Map Cello Library using PSR-0 standard namespace.
|
*/

Autoloader::namespaces(array(
	'Cello\Model'     => Bundle::path('cello').'models'.DS,
	'Cello\Presenter' => Bundle::path('cello').'presenters'.DS,
	'Cello'           => Bundle::path('cello').'libraries'.DS,
));

/*
|--------------------------------------------------------------------------
| Start your engine
|--------------------------------------------------------------------------
*/

Cello\Core::start();
