<?php namespace App\Controllers;

use App\Core\View;

class Main extends Base {

	public function showIndex()
	{
		$title = 'Feeds';
		$feeds = $this->getFeeds();
		return View::make('index')->with(compact('title', 'feeds'))->render();
	}

}
