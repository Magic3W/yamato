<?php

use spitfire\exceptions\PublicException;
use spitfire\Model;
use spitfire\storage\database\Schema;

class UserModel extends Model
{
	public function definitions(Schema $schema)
	{

	}

	public static function get($id) {
		try {
			return db()->table('user')->get('_id', $id)->first(true);
		} 
		catch (PublicException $e ) {
			$u = db()->table('user')->newRecord();
			$u->_id = $id;
			$u->store();
			return $u;
		} 
	}
}
