<?php

class Nastroj extends LapiModel {
	public $idAttribute = 'id_Alba';
	public $defaults = array(
		'id_Nastroje'      => NULL,
		'nazev'        => ''
	);

	public $db_table = 'Nastroje';

}


class Nastroje extends LapiCollection {
	public $db_table = 'Nastroje';
	public $model = 'Nastroj';
}