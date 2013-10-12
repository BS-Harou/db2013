<?php

require_once($app->dirModels . '/Users.php');

if (!isset($_POST['nick'])) {
	$app->redirect('main');
}

$nick = $_POST['nick'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];
$email = $_POST['email'];
$conditions = $_POST['conditions'];

// NICK
if ($nick != stripString($nick) || strlen($nick) < 3) {
	echo '{ "error": "Přezdívka obsahuje neplatné znaky nebo je kratší jak 3 znaky." }';
	exit;
}

// PASS
if ($pass1 != $pass2 || strlen($pass1) < 5) {
	echo '{ "error": "Hesla se nerovnají nebo je heslo příliš krátké." }';
	exit;
}

// EMAIL
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	echo '{ "error": "Špatný formát emailu" }';
	exit;
}

// CONDITIONS
if ($conditions != 'on') {
	echo '{ "error": "K dokončení registrace musíte souhlasit s podmínkami." }';
	exit;
}

// USER EXISTS?
$users = new Users(array(
	'where' => array(
		'nick' => $nick
	),
	'limit' => 1
));

if ($users->length()) {
	echo '{ "error": "Přezdívku již používá jiný uživatel." }';
	exit;
}

$user = new User();
$user->set('nick', $nick);
$user->set('pass', md5($pass1));
$user->set('email', $email);
$user->save();

// mail(... 'Confirm bla bla');

echo '{ "success": true }';