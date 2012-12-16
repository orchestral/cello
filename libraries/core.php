<?php namespace Cello;

use Orchestra\Core as O,
	Orchestra\Acl;

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
	}
}