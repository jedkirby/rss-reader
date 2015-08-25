<?php namespace App\Controllers;

use App\Core\View;
use App\Core\Input;
use App\Core\Cookie;
use App\Core\Validation;
use App\Core\Feeder;

class Feed extends Base {

	public function showView()
	{

		if( !($feed = $this->getFeed()) ){
			return View::handleError('Unable to located feed.');
		}

		$title = $feed->name;
		$feeds = $this->getFeeds();

		try {

			$feeder = new Feeder($feed->url);
			$feeder->fetchFeed();

		}
		catch( \Exception $e ){
			return View::handleError($e->getMessage(), 500);
		}
		
		return View::make('feed.view')->with(compact('title', 'feeds', 'feed', 'feeder'))->render();

	}

	public function showAdd()
	{
		return $this->handleEdit();
	}

	public function showEdit()
	{
		if( !($feed = $this->getFeed()) ){
			return View::handleError('Unable to located feed.');
		}
		return $this->handleEdit($feed);
	}

	protected function handleEdit($feed = null)
	{

		$errors = [];
		$title  = ($feed ? 'Edit'      : 'Add').' Feed';
		$name   = ($feed ? $feed->name : '');
		$url    = ($feed ? $feed->url  : '');
		$feeds  = $this->getFeeds();

		if( Input::method() === 'POST' ){

			$name = Input::post('name', $name);
			$url  = Input::post('url', $url);

			$val = new Validation();
			$val->add('name', ['required'], $name);
			$val->add('url',  ['required', 'url', 'xml'], $url);

			if( $val->run() ){

				if( $feed ){
					$query = $this->app->db->query('UPDATE feeds SET name = :name, url = :url WHERE id = :id');
					$query->bind(':id', $feed->id);
				}
				else {
					$query = $this->app->db->query('INSERT INTO feeds VALUES (null, :name, :url)');
				}

				$query->bind(':name', $name);
				$query->bind(':url',  $url);

				if( $query->execute() ){

					Cookie::set('status', 'success');
					Cookie::set('message', 'Feed saved!');

					return View::redirect('/feed?id='.( $feed ? $feed->id : $query->getLastInsertId() ));

				}

			}
			else {
				$errors = $val->errors();
			}

		}

		return View::make('feed.edit')->with(compact('title', 'feeds', 'name', 'url', 'errors'))->render();

	}

	public function showRemove()
	{

		if( !($feed = $this->getFeed()) ){
			return View::handleError('Unable to located feed.');
		}

		$title = 'Remove Feed';
		$feeds = $this->getFeeds();

		if( Input::method() === 'POST' ){

			$query = $this->app->db->query('DELETE FROM feeds WHERE id = :id');
			$query->bind(':id', $feed->id);

			if( $query->execute() ){

				Cookie::set('status', 'danger');
				Cookie::set('message', 'Feed removed!');

				return View::redirect('/');

			}

		}

		return View::make('feed.remove')->with(compact('title', 'feeds', 'feed'))->render();

	}

}
