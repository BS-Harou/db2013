<?php

/**
 * Params
 */

class Params extends DefaultParams {
	public $error_msg = false;
	public $collection;
	public $is_admin;
}

$params = new Params();
$params->collection = $url->params[0];
$params->is_admin = $app->user->get('id_Role') == 3;

/**
 * Render
 */
render('admin', $params);