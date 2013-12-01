<?php


$collection = $url->params[0];
$id = $url->params[1];

$names = array('Uzivatele', 'Skupiny', 'Pisnicky', 'Alba', 'Clenove', 'Vydavatele');

if (!in_array($collection, $names) || !$id) {
	$app->redirect('admin/' . $collection);
	echo 'No such collection';
	exit;
}

require_once($app->dirModels . '/' . $collection . '.php');

if ($id == 'all') {
	$app->db->query('DELETE * FROM `' + $collection + '`');
} else {
	$id = (int) $id;

	$coll = new $collection();
	$dummy = $coll->create(array(), array('simple' => true));

	$coll->fetch(array(
		'where' => array(
			$dummy->idAttribute => $id
		),
		'limit' => 1
	));

	if ($coll->length() == 1) {
		$success = $coll->at(0)->destroy();			
	}
}

$app->redirect('admin/' . $collection);