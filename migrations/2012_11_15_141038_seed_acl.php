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
		$role  = Orchestra\Model\Role::find(
			Config::get('orchestra::orchestra.default_role', 1)
		);

		$cello = Orchestra\Acl::register('cello', function($acl) use ($role)
		{
			$acl->add_action('manage pages');
			$acl->add_role($role->name);

			$acl->allow($role->name, 'manage pages');
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
