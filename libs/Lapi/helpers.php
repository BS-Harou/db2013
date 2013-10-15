<?php
// seznam funkcí které budou vždy dostupné

/**
 * Odstraní z řetězce vše až na čísla
 */
function getNumber($str) {
	return preg_replace('/[^0-9]/', '', $str);
}

/**
 * Odstraní z řetězce vše až na čísla, psímena a znaky -_:
 */
function stripString($str) {
	return preg_replace('/[^a-zA-Z0-9\-_:]/', '', $str);	
}


/**
 * Pomocí Mustache templatů vypíše HTML do stránky
 */
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