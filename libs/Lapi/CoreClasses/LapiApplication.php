<?php

/**
 * Hlavní třída apliakce.
 * @class LapiApplication
 */
class LapiApplication {

	/**
	 * Reference na instanci LapiDatabase pokud používáme databázi
	 * @type LapiDatabase
	 */
	public $database;

	/**
	 * Cesta k sekcím
	 * @type String
	 */
	public $dirSections = 'app/sections';

	/**
	 * Cesta k modelům
	 * @type String
	 */
	public $dirModels = 'app/models';

	/**
	 * Cesta k templatům
	 * @type String
	 */
	public $dirTemplates = 'app/templates';

	/**
	 * Cesta ke statickým objektům (css, js, obrázky)
	 * @type String
	 */
	public $dirStatic = './static';
	
	/**
	 * Reference na model přihlášeného uživatele. 
	 * @type LapiModel
	 */
	public $user = NULL;

	/**
	 * Konstruktor, vytvoří novou instanci LapiDatabase	 
	 */
	public function __construct() {
		$this->database = new LapiDatabase(DB_USER, DB_PASS, DB_HOST, DB_DB);
	}

	/**
	 * Vrátí base_url aplikace
	 */
	public function getRealRoot() {
		$r = $_SERVER['PHP_SELF'];
		$r = preg_replace("/index\.php$/", '', $r);
		$r = preg_replace("/[^\w\s\+%\/]/", '', $r);
		return $r;
	}

	/**
	 * Přesměruje klienta do jiné sekce
	 * @type String
	 */
	public function redirect($section) {
		header('Location: ' . $this->getRealRoot() . $section);
		exit;
	}

	/**
	 * Zkratka 'db' k vlastnosti database
	 */
	public function __get($name) {
		if ($name == 'db') return $this->database;
	}
	public function __isset($name) {
		if ($name == 'db') return true;
		return false;
	}
}