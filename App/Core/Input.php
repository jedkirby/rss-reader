<?php namespace App\Core;

class Input {

	/**
	 * Retrieve a get variable.
	 * 
	 * @param  string $key
	 * @param  mixed  $default
	 * @return mixed
	 */
	public static function get($key = null, $default = null)
	{
		return static::retrieve($_GET, $key, $default);
	}

	/**
	 * Retrieve a post variable.
	 * 
	 * @param  string $key
	 * @param  mixed  $default
	 * @return mixed
	 */
	public static function post($key = null, $default = null)
	{
		return static::retrieve($_POST, $key, $default);
	}

	/**
	 * Retrieve the request method.
	 * 
	 * @return string
	 */
	public static function method()
	{
		return static::retrieve($_SERVER, 'REQUEST_METHOD', 'GET');
	}

	/**
	 * Generic retrival method.
	 * 
	 * @param  mixed  $type
	 * @param  string $key
	 * @param  mixed  $default
	 * @return mixed
	 */
	protected static function retrieve($type, $key, $default)
	{
		return ( array_key_exists($key, $type) ? htmlspecialchars($type[$key]) : $default );
	}

}
