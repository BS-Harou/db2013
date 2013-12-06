<?php

/**
 * Třída pro tvorbu modelů typu SkupinaJoinClen
 * @class SkupinaJoinClen
 */
class SkupinaJoinClen extends LapiModel {
	//public $idAttribute = array('id_Skupiny', 'id_Clenove');
	public $defaults = array(
		'id_Skupiny'   => NULL,
		'id_Clenove'   => NULL,
		'aktivni'      => true,
		'rok_zacatku'  => '',
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