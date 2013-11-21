<?php
/**
 * Pouze pro AJAX requesty. Vrací seznam skladeb, hudebníků, a dalších modelů
 */

// MUSÍ SE PŘIDAT KONTROLA STATUSU ADMIN

header('Content-Type: application/json; charset=utf-8');

$collection = $url->params[0];

$names = array('Uzivatele', 'Skupiny', 'Pisnicky', 'Alba', 'Hudebnici', 'Vydavatele');

if (!in_array($collection, $names)) {
	echo '{ "error": "Neznáma kolekce" }';
	exit;
}

$c = new $collection();
$c->fetch(array(
	'limit' => 50
));

echo $c->toJSON();