<?php

class Clen extends LapiModel {
	public $idAttribute = 'id_Clenove';
	public $defaults = array(
		'id_Clenove'     => NULL,
		'jmeno'          => '',
		'prijmeni'       => '',
		'datum_narozeni' => '',
		'datum_umrti'    => '',
		'misto_narozeni' => '',
		'historie'       => '',
		'www'            => ''
	);

	public $db_table = 'Clenove';
}


class Clenove extends LapiCollection {
	public $db_table = 'Clenove';
	public $model = 'Clen';
}