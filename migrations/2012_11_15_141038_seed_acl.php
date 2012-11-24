<?php

class Cello_Seed_Acl {

	/**
	 * Start Orchestra during construct
	 *
	 * @return void
	 */
	public function __construct()
	{
		Bundle::start('orchestra');

		if (false === Orchestra\Installer::installed())
		{
			throw new RuntimeException("Orchestra need to be install first.");
		}
	}

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		$cello = Orchestra\Acl::register('cello', function($acl)
		{
			$acl->add_action('manage pages');
			$acl->add_role('Administrator');

			$acl->allow('Administrator', 'manage pages');
		});

		$cello->attach(Orchestra::memory());

		return true;
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{

	}

}
