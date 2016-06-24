<?php

/* CakeSessions schema generated on: 2011-06-12 11:06:13 : 1307847253 */

class CakeSessionsSchema extends CakeSchema {

	public $name = 'CakeSessions';

	public $file = 'cake_sessions.php';

	public $connection = 'baser';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $cake_sessions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 8, 'key' => 'primary'),
		'date' => array('type' => 'text', 'null' => true, 'default' => null),
		'expires' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 11),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci')
	);

}
