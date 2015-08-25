<?php namespace App\Core;

use \Exception;
use \SimpleXmlElement;

class Feeder {

	/**
	 * Feeder instance.
	 * 
	 * @var Database
	 */
	protected static $instance;

	/**
	 * Default reader parser.
	 * 
	 * @var string
	 */
	protected static $defaultVersion = '1.0';

	/**
	 * Feeder URL.
	 * 
	 * @var string
	 */
	protected $url;

	/**
	 * Xml Data
	 * 
	 * @var SimpleXmlElement
	 */
	protected $xml;

	/**
	 * Parser to use for feed.
	 * 
	 * @var App\Core\Feeder\Parser
	 */
	protected $parser;

	/**
	 * Versions and associated feeder parsers.
	 * 
	 * @var array
	 */
	protected static $versions = [
		'1.0' => 'App\\Core\\Feeder\\Rss10',
		'2.0' => 'App\\Core\\Feeder\\Rss20',
	];

	/**
	 * Constructor.
	 * 
	 * @param string|null  $url
	 * @param boolean      $internalErrors
	 */
	public function __construct($url = null, $internalErrors = true)
	{
		$url and $this->setUrl($url);
		$this->internalErrors($internalErrors);
	}

	/**
	 * Force the reader to use internal errors (Exceptions)
	 * 
	 * @param  boolean $state
	 * @return void
	 */
	public function internalErrors($state = true)
	{
		libxml_use_internal_errors($state);
	}

	/**
	 * Set the URL to parse.
	 * 
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->url = $url;
	}

	/**
	 * Fetch the feed and store the response.
	 * 
	 * @return void
	 */
	public function fetchFeed()
	{

		if( !$this->url ){
			throw new Exception('Unable to fetch feed without a feed url');
		}

		$this->setErrorHandler();

		$this->xml = new SimpleXmlElement($this->url, null, true);

		$this->resetErrorHandler();

	}

	/**
	 * Handle the multiple version of the parser.
	 *
	 * @throws Exception
	 * @return App\Modules\Feeder\Parser
	 */
	protected function parser()
	{

		if( is_null($this->parser) ){

			$contentVersion = $this->xml->attributes()->version;
			$versionNumber  = ( $contentVersion ? reset($contentVersion) : static::$defaultVersion );

			if( array_key_exists($versionNumber, static::$versions) ){

				$parserClass = static::$versions[$versionNumber];

				if(class_exists($parserClass)){
					$this->parser = new $parserClass($this->xml);
					return $this->parser;
				}

			}

			throw new Exception('Unable to initiate a parser for the version: "'.$versionNumber.'"');

		}

		return $this->parser;

	}

	/**
	 * Set the error handler to catch warnings/errors.
	 *
	 * @return  void
	 */
	protected function setErrorHandler()
	{
		set_error_handler(function($errNo, $errStr, $errFile, $errLine) {
			throw new Exception($errStr, $errNo);
		});
	}

	/**
	 * Reset the error handler back to what it was before.
	 * 
	 * @return void
	 */
	protected function resetErrorHandler()
	{
		restore_error_handler();
	}

	/**
	 * Magic call method to perform methods on the parser.
	 * 
	 * @param  string $method
	 * @param  mixed  $arguments
	 * @return mixed
	 */
	public function __call($method, $arguments)
	{
		return call_user_func_array([$this->parser(), $method], $arguments);
	}

}
