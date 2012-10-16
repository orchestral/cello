<?php

class Cello_Create_Pages {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cello_pages', function ($table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('title');
			$table->text('content')->nullable();
			$table->string('slug')->nullable();
			$table->blob('meta')->nullable();
			$table->string('status')->default('draft');

			$table->timestamps();
			$table->index('user_id');
			$table->index('slug');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cello_pages');
	}

}