<?php namespace App\Core\Feeder;

use \SimpleXmlElement;

abstract class Parser {

	/**
	 * Xml Data
	 * 
	 * @var SimpleXmlElement
	 */
	protected $xml;

	/**
	 * Constructor.
	 * 
	 * @param SimpleXmlElement $xml
	 */
	public function __construct(SimpleXmlElement $xml)
	{
		$this->xml = $xml;
	}

	/**
	 * Return the current parser version.
	 * 
	 * @return string
	 */
	public function version()
	{
		return static::$version;
	}

	/**
	 * Return the xml channel data.
	 * 
	 * @return string
	 */
	public function channel()
	{
		return $this->xml->channel;
	}

	/**
	 * Abstract method to return the xml items.
	 * 
	 * @return mixed
	 */
	abstract public function items();

}
