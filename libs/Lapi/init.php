<?php

/**
 * Load stuff
 */

require_once('helpers.php');
require_once('CoreClasses/LapiApplication.php');

/**
 * Nastavení autoloaderu, aby pokud parser narazí na nový název třídy tak se podíval do složky CoreClasses
 */
spl_autoload_register(function ($class) {
    require_once('CoreClasses/' . $class . '.php');
});



/**
 * Vytvoření nové globální instance LapiApplication 
 */
$app = new LapiApplication();
$GLOBALS['app'] = $app;
