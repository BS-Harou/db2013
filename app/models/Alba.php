<?php

require_once($app->dirModels . '/Vydavatele.php');


/**
 * Třída pro tvorbu modelů typu Album
 * @class Album
 */
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

	/**
	 * Vrati model vydavatele daneho alba
	 * @return Vydavatel
	 */
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

	/**
	 * Zmeni ID skupiny
	 * @param {Skupina|Int} ID nebo model skupiny
	 * @return Bool
	 */
	public function priraditDoJineSkupiny($skupina) {
		if (is_numeric($skupina)) {
			$this->set('id_Skupiny', $skupina);	
		} else if ($skupina instanceof LapiModel) {
			$this->set('id_Skupiny', $skupina->getId());
		} else {
			return false;
		}
		
		return $this->save();
	}

	/**
	 * Zmeni ID vydavatele
	 * @param {Vydavatel|Int} ID nebo model vydavatele
	 * @return Bool
	 */
	public function zadatJinehoVydavatele($vydavatel) {
		if (is_numeric($vydavatel)) {
			$this->set('id_Vydavatel', $vydavatel);	
		} else if ($vydavatel instanceof LapiModel) {
			$this->set('id_Vydavatel', $vydavatel->getId());
		} else {
			return false;
		}
		
		return $this->save();
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

/**
 * Třída pro práci s modely typu Album
 * @class Alba
 */
class Alba extends LapiCollection {
	public $db_table = 'Alba';
	public $model = 'Album';
}