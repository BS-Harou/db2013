<?php

class Skupina extends LapiModel {
	public $idAttribute = 'id_Skupiny';
	public $defaults = array(
		'id_Skupiny'    => NULL,
		'nazev'         => NULL,
		'rok_zalozeni'  => 0,
		'historie'      => '',
		'www'           => ''
	);

	public $db_table = 'Skupiny';
}


class Skupiny extends LapiCollection {
	public $db_table = 'Skupiny';
	public $model = 'Skupina';
}