<?php

/**
 * Params
 */

class Params extends DefaultParams {
	public $error_msg = false;
}

$params = new Params();

/**
 * Render
 */
render('settings', $params);