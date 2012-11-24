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
	'Cello\Model' => Bundle::path('cello').'models'.DS,
	'Cello'       => Bundle::path('cello').'libraries'.DS,
));

/*
|--------------------------------------------------------------------------
| Define ACL
|--------------------------------------------------------------------------
|
| Define Cello ACL to be used with Orchestra.
|
*/

Orchestra\Acl::make('cello')->attach(Orchestra::memory());
