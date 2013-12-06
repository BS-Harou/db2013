<?php
/**
 * Pouze pro AJAX requesty. Vrací seznam skladeb, hudebníků, a dalších modelů
 */

// MUSÍ SE PŘIDAT KONTROLA STATUSU ADMIN

header('Content-Type: application/json; charset=utf-8');

$collection = $url->params[0];
$id = $url->params[1];

$names = array('Uzivatele', 'Skupiny', 'Zadosti', 'Skladby', 'Alba', 'Clenove', 'Vydavatele');

if (!in_array($collection, $names)) {
	echo '{ "error": "Neznáma kolekce" }';
	exit;
}

require_once($app->dirModels . '/' . $collection . '.php');

$c = new $collection();

if ($collection == 'Alba') {
	$c->fetch(array(
		'where' => array(
			'id_Skupiny' => $id
		),
		'limit' => 50
	));
} else if ($collection == 'Skladby') {
	$c->fetch(array(
		'where' => array(
			'id_Alba' => $id
		),
		'limit' => 50
	));
} else {
	$c->fetch(array(
		'limit' => 50
	));
}

echo $c->toJSON();