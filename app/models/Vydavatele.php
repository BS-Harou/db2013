<?php

/**
 * Třída pro tvorbu modelů typu Vydavatel
 * @class Vydavatel
 */
class Vydavatel extends LapiModel {
	public $idAttribute = 'id_Vydavatel';
	public $defaults = array(
		'id_Vydavatel'     => NULL,
		'nazev'            => '',
		'popis'            => '',
		'datum_zalozeni'   => ''
	);

	public $db_table = 'Vydavatele';
}


/**
 * Třída pro práci s modely typu Vydavatel
 * @class Vydavatele
 */
class Vydavatele extends LapiCollection {
	public $db_table = 'Vydavatele';
	public $model = 'Vydavatel';
}