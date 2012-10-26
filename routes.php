<?php

Route::any('(:bundle)/(:any?)', function ($page = '')
{
	return Controller::call('Cello::cms@index',array($page));
});

