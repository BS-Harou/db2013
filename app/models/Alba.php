<?php

require_once($app->dirModels . '/Vydavatele.php');

class Album extends LapiModel {
	public $idAttribute = 'id_Alba';
	public $defaults = array(
		'id_Alba'      => NULL,
		'nazev'        => '',
		'obal'         => '',
		'datum_vydani' => '',
		'delka_alba'   => '',
		'id_Skupiny'   => NULL,
		'id_Vydavatel' => NULL
	);

	public $db_table = 'Alba';

	public function vydavatelAlba() {
		$id = $this->get('id_Vydavatel');
		if (!$id || $id < 1) {
			// neni nastaveny vydavatel
			return NULL;
		}


		$vydavatel = new Vydavatel(array(
			'id_Vydavatel' => $id
		));
		$vydavatel->fetch();

		return $vydavatel;
	}

	/*
	//DB predpoklada 1:n vazbu, pro moznost vice vydavatelu je treba predelat DB na n:m

	public function pridatVydavatele($idVydavatel) {
		return false;
	}

	public function odebratVydavatele($idVydavatel) {
		return false;
	}
	*/

}


class Alba extends LapiCollection {
	public $db_table = 'Alba';
	public $model = 'Album';
}