<?php


$collection = $url->params[0];

$names = array('Uzivatele', 'Skupiny', 'Skladby', 'Alba', 'Clenove', 'Vydavatele');

if (!in_array($collection, $names)) {
	$app->redirect('admin/' . $collection);
	echo 'No such collection';
	exit;
}

require_once($app->dirModels . '/' . $collection . '.php');


$id = (int) $id;

$users = new $collection();

$users->create($_POST, array('wait' => true));

if ($users->length()) {
	echo '{ "success": true }';
} else {
	echo '{ "error": "MySQL error." }';
}