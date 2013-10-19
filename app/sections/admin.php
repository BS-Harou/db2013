<?php

/**
 * Params
 */

class Params extends DefaultParams {
	public $error_msg = false;
	public $collection;
}

$params = new Params();
$params->collection = $url->params[0];

/**
 * Render
 */
render('admin', $params);