<?php

/**
 * Třída pro tvorbu modelů typu Zadost
 * @class Zadost
 */
class Zadost extends LapiModel {
	public $idAttribute = 'id_Zadosti';
	public $defaults = array(
		/** 
		 * @attribute id_Zadosti
		 */
		'id_Zadosti'    =>  NULL,

		/** 
		 * @attribute datum
		 */
		'datum'  => '1.1.1990',

		/** 
		 * @attribute zpracovano
		 */
		'zpracovano' => false,

		/** 
		 * @attribute schvaleno
		 */
		'schvaleno'  => false,

		/** 
		 * @attribute id_Uzivatele
		 */
		'id_Uzivatele'  => 0
	);
	public $db_table = 'Zadosti';
}

/**
 * Třída pro práci s modely typu Zadost
 * @class Zadosti
 */
class Zadosti extends LapiCollection {
	public $db_table = 'Zadosti';
	public $model = 'Zadost';
}