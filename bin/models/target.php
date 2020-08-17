<?php

use spitfire\storage\database\Schema;

class TargetModel extends \spitfire\Model
{

	/**
	 * 
	 * @param $schema Schema
	 */
	public function definitions(Schema $schema) {
		$schema->redirection  = new Reference('redirection');
		$schema->to    = new StringField(255);
		$schema->since = new IntegerField(true);
		$schema->until = new IntegerField(true);
	}

}
