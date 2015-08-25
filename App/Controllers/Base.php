<?php namespace App\Controllers;

use App\Core\Controller;
use App\Core\Input;

class Base extends Controller {

	protected function getFeeds()
	{
		return $this->app->db->query('SELECT * FROM feeds')->getAll();
	}

	protected function getFeed($id = null)
	{
		$id or $id = Input::get('id');
		return $this->app->db->query('SELECT * FROM feeds WHERE id = :id')->bind(':id', $id)->getSingle();
	}

}
