<?php namespace App;

use App\Core\View;

class Core {

	/**
	 * Core instance.
	 * 
	 * @var App\Core
	 */
	protected static $app;

	/**
	 * Router instance.
	 * 
	 * @var App\Core\Router
	 */
	public $router;

	/**
	 * Database instance.
	 * 
	 * @var App\Core\Database
	 */
	public $db;

	/**
	 * Handle the autoloading of a new class.
	 * 
	 * @param  string $className
	 * @return void
	 */
	public static function autoload($className)
	{

		$className = ltrim($className, '\\');
		$fileName  = BASE_PATH.str_replace('\\', DS, $className).'.php';

		if( file_exists($fileName) ){
			require $fileName;
		}

	}

	/**
	 * Register the SPL autoloader.
	 * 
	 * @return void
	 */
	public static function registerAutoloader()
	{
		spl_autoload_register(__NAMESPACE__.'\\Core::autoload');
	}

	/**
	 * Register the exception handler.
	 * 
	 * @return void
	 */
	public function registerExceptionHandler()
	{
		set_exception_handler(function($e){
			return View::handleError($e->getMessage(), 500);
		});
	}

	/**
	 * Constructor.
	 */
	public function __construct()
	{

		if( is_null(static::getInstance()) ){

			$this->registerExceptionHandler();

			$this->router = new Core\Router();
			$this->db     = new Core\Database();

			static::$app = $this;

		}

		return static::$app;

	}

	/**
	 * Return the current Core instance.
	 * 
	 * @return App\Core|null
	 */
	public static function getInstance()
	{
		return ( isset(static::$app) ? static::$app : null );
	}

	/**
	 * Final run method.
	 * 
	 * @return mixed
	 */
	public function run()
	{
		echo $this->router->handle();
	}

}
