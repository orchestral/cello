<?php

Bundle::start('orchestra');
Bundle::start('cello');

class PresenterPageTest extends PHPUnit_Framework_TestCase {
	
	public function testInstanceIsCreatedProperly()
	{
		$page = new Cello\Model\Page;
		$form = Cello\Presenter\Page::form($page);
	}	
}