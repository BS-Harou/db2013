<?php

/**
 * Params
 */



class Params extends DefaultParams {
	public $error_msg = false;
	public $success_msg = false;
}

$params = new Params();

if ($_POST['action'] == 'change_password') {
	$ok = $app->user->zmenitHeslo($_POST['old_pass'], $_POST['new_pass'], $_POST['confirm_pass']);
	if (!$ok) {
		$params->error_msg = 'Heslo se nepodařilo změnit!';
	} else {
	$params->success_msg = 'Heslo úspěšně změněno.';
	}

}

/**
 * Render
 */
render('settings', $params);