<?php namespace App\Core\Feeder;

class Rss20 extends Parser {

	/**
	 * Parser version.
	 * 
	 * @var string
	 */
	protected static $version = '2.0';

	/**
	 * Return the xml item data.
	 * 
	 * @return array
	 */
	public function items()
	{
		return $this->xml->channel->item;
	}

}
