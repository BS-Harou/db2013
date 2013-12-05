<?php

/**
 * Params
 */

require_once($app->dirModels . '/Skupiny.php');

class Params extends DefaultParams {
	public $error_msg = false;
	public $bands = '[]';
}

$skupiny = new Skupiny(array(
	'limit' => 50
));

$params = new Params();
$params->bands = $skupiny->toJSON();

/**
 * Render
 */
render('wall_real', $params);