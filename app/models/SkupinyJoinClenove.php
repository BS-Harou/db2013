<?php


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


class SkupinyJoinClenove extends LapiCollection {
	public $db_table = 'Skupiny_Clenove';
	public $model = 'SkupinaJoinClen';
}