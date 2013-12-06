<?php

/**
 * Třída pro tvorbu modelů typu Nastroj
 * @class Nastroj
 */
class Nastroj extends LapiModel {
	public $idAttribute = 'id_Alba';
	public $defaults = array(
		/** 
		 * 
		 * @attribute id_Nastroje
		 */
		'id_Nastroje'      => NULL,

		/**
		 * 
		 * @attribute id_Nazev
		 */
		'nazev'        => ''
	);

	public $db_table = 'Nastroje';

}

/**
 * Třída pro práci s modely typu Nastroj
 * @class Nastroje
 */
class Nastroje extends LapiCollection {
	public $db_table = 'Nastroje';
	public $model = 'Nastroj';
}