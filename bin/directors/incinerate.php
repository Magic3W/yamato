<?php

use spitfire\mvc\Director;

class IncinerateDirector extends Director
{
	/**
	 * Removes all entries older than the given age (in days)
	 * 
	 * @param  int $age
	 * @return void
	 */
	public function redirections(int $age = 365)
	{
		$timestamp = time() - ($age * 24 * 60 * 60);
		console()->info('Removing all redirections and targets older than ' . date('Y-m-d H:i:s', $timestamp) . '!')->ln();

		db()->table('target')->get('until', $timestamp, '<')->all()->each(function ($e) {
			$redirection = $e->redirection;

			$e->delete();

			if ($redirection->targets->getQuery()->count() == 0) {
				$redirection->delete();
			}
		});

		console()->success('Done')->ln();
	}
}
