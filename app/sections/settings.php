<?php

/**
 * Params
 */

require_once($app->dirModels . '/Zadosti.php');

class Params extends DefaultParams {
	public $error_msg = false;
	public $success_msg = false;
	public $nezazadano = true;
}



//var_dump($zadosti->length());
//exit;

$params = new Params();


if ($_POST['action'] == 'change_password') {
	$ok = $app->user->zmenitHeslo($_POST['old_pass'], $_POST['new_pass'], $_POST['confirm_pass']);
	if (!$ok) {
		$params->error_msg = 'Heslo se nepodařilo změnit!';
	} else {
		$params->success_msg = 'Heslo úspěšně změněno.';
	}

} else if ($_POST['action'] == 'ask_for_permissions') {
	$ok = $app->user->zazadatModPrava();
	if (!$ok) {
		$params->error_msg = 'Žádost se nepodařilo vytvořit';
	} else {
		$params->success_msg = 'Úspěšně jste zažádal o mod. práva!';
	}
}

$zadosti = new Zadosti(array(
	'where' => array(
		'id_Uzivatele' => $app->user->get('id_Uzivatele')
	),
	'limit' => 1
));
$params->nezazadano = !$zadosti->length();

/**
 * Render
 */
render('settings', $params);