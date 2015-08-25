<?php namespace App\Core\Feeder;

class Rss10 extends Parser {

	/**
	 * Parser version.
	 * 
	 * @var string
	 */
	protected static $version = '1.0';

	/**
	 * Return the xml item data.
	 * 
	 * @return array
	 */
	public function items()
	{
		return $this->xml->item;
	}

}
