<?php namespace App\Core;

class Cookie {

	/**
	 * Set a cookie.
	 * 
	 * @param  string $key
	 * @param  string $value
	 * @return void
	 */
	public static function set($key, $value)
	{
		static::setItem($key, $value, ( time() + 3600 ));
	}

	/**
	 * Alias to get a cookie value and remove it.
	 * 
	 * @param  string $key
	 * @param  string $default
	 * @return mixed
	 */
	public static function once($key, $default = null)
	{
		return static::get($key, $default, true);
	}

	/**
	 * Get a cookie value.
	 * 
	 * @param  string  $key
	 * @param  string  $default
	 * @param  boolean $remove   Whether to remove the cookie afterwards.
	 * @return mixed
	 */
	public static function get($key, $default = null, $remove = false)
	{

		$value = $default;

		if( array_key_exists($key, $_COOKIE) ){

			$value = ( $_COOKIE[$key] ?: $default );
			$remove and static::remove($key);

		}

		return $value;

	}

	/**
	 * Remove a cookie.
	 * 
	 * @param  string $key
	 * @return void
	 */
	public static function remove($key)
	{
		static::setItem($key, '', ( time() - 1 ));
	}

	/**
	 * Actually set s cookie with a expiry time.
	 * 
	 * @param  string $key
	 * @param  string $value
	 * @param  int    $expiry
	 * @param  string $path
	 * @return void
	 */
	protected static function setItem($key, $value, $expiry, $path = '/')
	{
		setcookie($key, $value, $expiry, $path);
	}

}
