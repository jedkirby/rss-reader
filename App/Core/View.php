<?php namespace App\Core;

use \App\Core;
use \Exception;

class View {

	/**
	 * Data.
	 * 
	 * @var array
	 */
	protected $data = [];

	/**
	 * View file.
	 * 
	 * @var string
	 */
	protected $file;

	/**
	 * Return a new View instance.
	 * 
	 * @return App\Core\View
	 */
	public static function getInstance()
	{
		return new self();
	}

	/**
	 * Define the file path to the view.
	 * 
	 * @param  string $name
	 * @return self
	 */
	public static function make($name)
	{
		return static::getInstance()->makeView($name);
	}

	/**
	 * Actually make the view.
	 * 
	 * @param  string $name
	 * @throws Exception
	 * @return self
	 */
	protected function makeView($name)
	{

		$path = rtrim($name, '.php'); // Trim off the ".php" if it's set, we'll add it later
		$path = str_replace('.', DS, $path); // Provide support for dot notation
		$path = static::getPath().$path.'.php';

		if( !file_exists($path) ){
			throw new Exception('Unable to load the view "'.$name.'".');
		}

		$this->file = $path;

		return $this;

	}

	/**
	 * Determine the path to the views folder.
	 * 
	 * @return string
	 */
	public static function getPath()
	{
		return APP_PATH.'views'.DS;
	}

	/**
	 * Share data with the view.
	 * 
	 * @param  sting|array $key
	 * @param  string|null $value This is ignored if $key is an array
	 * @return $this
	 */
	public function with($key, $value = null)
	{
		if(is_array($key)){
			foreach($key as $k => $v){
				$this->set($k, $v);
			}
		}
		else {
			$this->set($key, $value);
		}
		return $this;
	}

	/**
	 * Set a data item.
	 * 
	 * @param string $key
	 * @param mixed  $value
	 */
	protected function set($key, $value)
	{
		$this->data[$key] = $value;
	}

	/**
	 * Set the HTTP status.
	 * 
	 * @param  integer $code
	 * @return $this
	 */
	public function setHttpStatus($code = 200)
	{
		http_response_code($code);
		return $this;
	}

	/**
	 * Handle errors.
	 * 
	 * @param  string  $message
	 * @param  integer $code
	 * @return mixed
	 */
	public static function handleError($message, $code = 404)
	{
		return static::make('error')
			->setHttpStatus($code)
			->with('title', 'Oops!')
			->with(compact('message', 'code'))
			->render();
	}

	/**
	 * Render the view with the data.
	 * 
	 * @return mixed
	 */
	public function render()
	{
		extract($this->data);
		include($this->file);
	}

	/**
	 * Redirector.
	 * 
	 * @param  string $url
	 * @return void
	 */
	public static function redirect($url)
	{
		header('Location: '.$url); die;
	}

}
