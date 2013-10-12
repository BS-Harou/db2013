<?php

class User extends LapiModel {
	public $idAttribute = 'nick';
	public $defaults = array(
		'id'    =>  NULL,
		'nick'  => NULL,
		'pass' => '',
		'activated'  => false,
		/*'registered'  => 0, .. commented to get current timestamp */
		'email'  => 'no@email.at.all'
	);
	public $db_table = 'users';
}


class Users extends LapiCollection {
	public $db_table = 'users';
	public $model = 'User';
}