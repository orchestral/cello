<?php

class Cello_Pages_Controller extends Controller 
{
	public $restful = true;

	public function get_index()
	{
		return "Hello";
	}	
}