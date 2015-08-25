<?php namespace App\Core;

use \App\Core;

abstract class Controller {

	/**
	 * Core application instance.
	 * 
	 * @var App\Core
	 */
	protected $app;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->app = Core::getInstance();
	}

}
