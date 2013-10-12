<?php

require_once($app->dirModels . '/Users.php');

/**
 * Define functions
 */
function login($nick, $pass) {
	global $app;

	$users = new Users(array(
		'where' => array(
			'nick' => $nick,
			'pass' => $pass
		),
		'limit' => 1
	));
	
	if ($users->length() > 0) {   
		$user = $users->at(0);
		$_SESSION['user_nick'] = $user->get('nick');

		$app->user = $user;
		
		return true;
	}

	return false;   
}

/**
 * Params
 */

class Params extends DefaultParams {
	public $error_msg = false;
}

$params = new Params();

/**
 * Move menu if logged
 */

if ($params->IS_LOGGED()) {
	$app->redirect( 'wall' );
}

if (isset($_GET['odhlasit'])) {
	$params->error_msg = 'Byli jste odhlášeni.';
}

/**
 * Handle POST
 */
if (isset($_POST['nick'])) {
	if (login($_POST['nick'], $_POST['pass'])) {
		$app->redirect( 'wall' );
	} else {
		$params->error_msg = 'Nepodařilo se přihlásit.';
	}
}

/**
 * Render
 */
render('login', $params);