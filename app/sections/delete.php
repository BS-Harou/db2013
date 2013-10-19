<?php


$collection = $url->params[0];
$id = $url->params[1];

$names = array('users', 'bands', 'songs', 'albums', 'musicians', 'publishers');

if (!in_array($collection, $names) || !$id) {
	$app->redirect('admin/' . $collection);
	echo 'No such collection';
	exit;
}

if ($id == 'all') {
	$app->db->query('DELETE * FROM `' + $collection + '`');
} else {
	$id = (int) $id;
}

$users = new $collection(array(
	'where' => array(
		'id' => $id
	),
	'limit' => 1
));

if ($users->length() == 1) {
	$users->at(0)->destroy();	
} 

$app->redirect('admin/' . $collection);