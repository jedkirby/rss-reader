<?php namespace App\Core;

use \Exception;

class Router {

	/**
	 * Router instance.
	 * 
	 * @var Router
	 */
	protected static $instance;

	/**
	 * Registered routes.
	 * 
	 * @var array
	 */
	protected $routes = [];

	/**
	 * Current request URI.
	 * 
	 * @var string
	 */
	protected $uri;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		if( is_null(static::getInstance()) ){
			static::$instance = $this;
		}
		return static::$instance;
	}

	/**
	 * Return the current Router instance.
	 * 
	 * @return App\Router
	 */
	public static function getInstance()
	{
		return isset(static::$instance) ? static::$instance : null;
	}

	/**
	 * Register a route.
	 * 
	 * @param  string $uri
	 * @param  string $handler
	 * @return void
	 */
	public function add($uri, $handler)
	{
		$this->routes[$this->formatUri($uri)] = $handler;
	}

	/**
	 * Handle the current request.
	 * 
	 * @return void
	 */
	public function handle()
	{

		$this->getRequestUri();

		if(array_key_exists($this->uri, $this->routes)){

			$handler = $this->routes[$this->uri];

			list($controller, $method) = explode('@', $handler);

			if(class_exists($controller) && method_exists($controller, $method)){

				$class = new $controller();
				return $class->$method();

			}

		}

		throw new Exception('404 - Page Not Found.');

	}

	/**
	 * Get the request URI.
	 * 
	 * @return void
	 */
	protected function getRequestUri()
	{
		$url = parse_url($_SERVER['REQUEST_URI']);
		$this->uri = $this->formatUri($url['path']);
	}

	/**
	 * Format the URI.
	 * 
	 * @param  string $uri
	 * @return string
	 */
	protected function formatUri($uri)
	{
		$uri === '' and $uri = '/';
		return strtolower(( $uri === '/' ? $uri : trim($uri, '/') ));
	}

}
