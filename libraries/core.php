<?php namespace Cello;

use \Asset,
	\Event,
	Orchestra\Acl,
	Orchestra\Core as O;

class Core {
	
	/**
	 * Start your engine.
	 *
	 * @static
	 * @access public
	 * @return void
	 */
	public static function start()
	{
		Acl::make('cello')->attach(O::memory());

		// Append all Cello required assets for Orchestra Administrator 
		// Interface usage mainly on Resources page.
		Event::listen('orchestra.started: backend', function()
		{
			$asset = Asset::container('orchestra.backend: footer');

			$asset->script('redactor', 'bundles/orchestra/vendor/redactor/redactor.min.js', array('jquery', 'bootstrap'));
			$asset->script('cello', 'bundles/cello/js/cello.min.js', array('redactor'));
			$asset->style('redactor', 'bundles/orchestra/vendor/redactor/css/redactor.css', array('bootstrap'));
		});
	}
}