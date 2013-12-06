<?php

/**
 * Třída pro tvorbu modelů typu SkupinaJoinClen
 * @class SkupinaJoinClen
 */
class SkupinaJoinClen extends LapiModel {
	//public $idAttribute = array('id_Skupiny', 'id_Clenove');
	public $defaults = array(
		/** 
		 * @attribute id_Skupiny
		 */
		'id_Skupiny'   => NULL,

		/** 
		 * @attribute id_Clenove
		 */
		'id_Clenove'   => NULL,

		/** 
		 * @attribute aktivni
		 */
		'aktivni'      => true,

		/** 
		 * @attribute rok_zacatku
		 */
		'rok_zacatku'  => '',

		/** 
		 * @attribute rok_konce
		 */
		'rok_konce'    => ''
	);
	public $db_table = 'Skupiny_Clenove';
}

/**
 * Třída pro práci s modely typu SkupinaJoinClen
 * @class SkupinyJoinClenove
 */
class SkupinyJoinClenove extends LapiCollection {
	public $db_table = 'Skupiny_Clenove';
	public $model = 'SkupinaJoinClen';
}