<?php

use spitfire\storage\database\Schema;

class RedirectionModel extends \spitfire\Model
{

	/**
	 * 
	 * @param $schema Schema
	 */
	public function definitions(Schema $schema) {
		$schema->user  = new Reference('user');
		$schema->alias = new StringField(255);
		$schema->targets = new ChildrenField('target', 'redirection');
	}

}
