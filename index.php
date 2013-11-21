<?php
error_reporting(E_ALL - E_NOTICE); ini_set('display_errors', 'On'); 
header('Content-Type: text/html; charset=utf-8');



/**
 * Sessions
 */

session_start();

/**
 * Templating library
 */

require_once('libs/Mustache/Autoloader.php');
Mustache_Autoloader::register();

/**
 * Database login
 */
require_once('db_login.php');

/**
 * Main Lapi Library
 */

require_once('libs/Lapi/init.php');

/**
 * "Router"
 */
$url;
$GLOBALS['url'] = $url;

if (isset($_GET['str'])) {
	$url = new LapiURL($_GET['str']);
} else {
	$url = new LapiURL();
}

if (isset($_SESSION['user_nick'])) {

	require_once($app->dirModels . '/Uzivatele.php');
	$app->user = new Uzivatel();
	$app->user->set('nick', $_SESSION['user_nick']);
	$app->user->fetch();

}

if ($url->section) {
	$path = $app->dirSections . '/' . $url->section . '.php';
	if (file_exists($path)) {
		include($path);
	} else {
		render('e404');
	}
} else {
	$app->redirect('main');
}


/*} else {
	include($app->dirSections . '/main.php');
}*/


