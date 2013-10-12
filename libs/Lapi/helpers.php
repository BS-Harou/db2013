<?php

function getNumber($str) {
	return preg_replace('/[^0-9]/', '', $str);
}

function stripString($str) {
	return preg_replace('/[^a-zA-Z0-9\-_:]/', '', $str);	
}

function render($name, $params = NULL) {
	global $app;
	if (is_null($params)) $params = new DefaultParams();
	$m = new Mustache_Engine();

	$name = preg_replace('/[^a-zA-Z0-9\-_]/', '', $name);

	$body = file_get_contents($app->dirTemplates . '/' . $name . '.html');
	$layout = file_get_contents($app->dirTemplates . '/layout.html');

	$body = str_replace('{{BODY}}', $body, $layout);

	echo $m->render($body, $params);
}