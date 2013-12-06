<?php

/**
 * Třída pro tvorbu modelů typu Vydavatel
 * @class Vydavatel
 */
class Vydavatel extends LapiModel {
	public $idAttribute = 'id_Vydavatel';
	public $defaults = array(
		/** 
		 * @attribute id_Vydavatel
		 */
		'id_Vydavatel'     => NULL,

		/** 
		 * @attribute nazev
		 */
		'nazev'            => '',

		/** 
		 * @attribute popis
		 */
		'popis'            => '',

		/** 
		 * @attribute datum_zalozeni
		 */
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