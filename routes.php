<?php

use \Config;

Route::any('(:bundle)/(:any)?', function ($page = '')
{
	return Controller::call('cello::pages@index', array($page));
});