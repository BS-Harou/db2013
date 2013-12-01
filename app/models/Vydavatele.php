<?php

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


class Vydavatele extends LapiCollection {
	public $db_table = 'Vydavatele';
	public $model = 'Vydavatel';
}