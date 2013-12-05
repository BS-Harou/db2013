<?php

class Skladba extends LapiModel {
	public $idAttribute = 'id_Skladby';
	public $defaults = array(
		'id_Skladby'   => NULL,
		'nazev'        => '',
		'text'         => '',
		'youtube'      => '',
		'delka'        => '',
		'id_Alba'      => NULL,
	);

	public $db_table = 'Skladby';

}


class Skladby extends LapiCollection {
	public $db_table = 'Skladby';
	public $model = 'Skladba';
}