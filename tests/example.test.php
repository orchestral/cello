<?php

Bundle::start('orchestra');

class ExampleTest extends Orchestra\Testable\TestCase {
	
	/**
	 * Setup the test environment.
	 */
	public function setUp()
	{
		parent::setUp();

		Orchestra\Extension::detect();
		Orchestra\Extension::activate('cello');
	}

	/**
	 * Teardown the test environment.
	 */
	public function tearDown()
	{
		Orchestra\Extension::deactivate('cello');

		parent::tearDown();
	}

	/**
	 * Test example.
	 *
	 * @test
	 */
	public function testExample()
	{
		$this->assertTrue(true);
	}
}
