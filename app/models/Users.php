<?php

//require_once($app->dirModels . '/Permissions.php');

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

	public function changePassword($oldPass, $newPass, $confirmPass) {
		if ($newPass != $confirmPass) return false;
		if (strlen($newPass) < 5) return false;

		
		$oldPass = md5($oldPass);
		if ($oldPass != $this->get('pass')) return false;

		$newPass = md5($newPass);
		$this->set('pass', $newPass);
		return $this->save();
	}

	public function requestModPermissions() {
		/*new Permission(array(
			'user_id' => $this->get('id'),

		));*/
	}
}


class Users extends LapiCollection {
	public $db_table = 'users';
	public $model = 'User';
}