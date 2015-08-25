<?php namespace App\Core;

use \Exception;

class Config {

	/**
	 * Configuration file instances.
	 * 
	 * @var array
	 */
	protected static $instances = [];

	/**
	 * Load a configuration file.
	 * 
	 * @param  string $name
	 * @return array
	 */
	public static function load($name)
	{

		if( !array_key_exists($name, static::$instances) ){

			$path = APP_PATH.'config'.DS.$name.'.php';

			if( !file_exists($path) ){
				throw new Exception('Unable to locate the config file "'.$name.'"');
			}

			static::$instances[$name] = include($path);

		}

		return static::$instances[$name];

	}

	/**
	 * Get a configuration item.
	 * 
	 * @param  string $name
	 * @param  string $item
	 * @param  mixed  $default
	 * @return mixed
	 */
	public static function get($name, $item, $default = null)
	{

		if( array_key_exists($name, static::$instances) ){

			$config = static::$instances[$name];

			return ( array_key_exists($item, $config) ? $config[$item] : $default );

		}

		return $default;

	}

}
