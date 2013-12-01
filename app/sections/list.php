<?php
/**
 * Pouze pro AJAX requesty. Vrací seznam skladeb, hudebníků, a dalších modelů
 */

// MUSÍ SE PŘIDAT KONTROLA STATUSU ADMIN

header('Content-Type: application/json; charset=utf-8');

$collection = $url->params[0];

$names = array('Uzivatele', 'Skupiny', 'Pisnicky', 'Alba', 'Clenove', 'Vydavatele');

if (!in_array($collection, $names)) {
	echo '{ "error": "Neznáma kolekce" }';
	exit;
}

require_once($app->dirModels . '/' . $collection . '.php');

$c = new $collection();
$c->fetch(array(
	'limit' => 50
));

echo $c->toJSON();