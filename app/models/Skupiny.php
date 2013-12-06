<?php

require_once($app->dirModels . '/Clenove.php');
require_once($app->dirModels . '/SkupinyJoinClenove.php');
require_once($app->dirModels . '/Alba.php');

/**
 * Třída pro tvorbu modelů typu Skupina
 * @class Skupina
 */
class Skupina extends LapiModel {
	public $idAttribute = 'id_Skupiny';
	public $defaults = array(
		'id_Skupiny'    => NULL,
		'nazev'         => NULL,
		'rok_zalozeni'  => 0,
		'historie'      => '',
		'www'           => '',
		'foto'          => ''
	);

	public $db_table = 'Skupiny';

	/**
	 * Prida clena skupine
	 * @param {int} ID Clena
	 * @return Bool
	 */
	public function pridatClena($idClenove) {
		$clen = new Clen(array('id_Clenove' => $idClenove));

		if ($clen->isNew()) return false;
		if ($this->isNew()) return false;

		$spojeni = new SkupinaJoinClen(array(
			'id_Clenove' => $idClenove,
			'id_Skupiny' => $this->getId()
		));

		return $spojni->save();
	}

	/**
	 * Prida album skupine
	 * @param {int} ID alba
	 * @return Bool
	 */
	public function pridatAlbum($idAlba) {
		return false;
	}

	/**
	 * Odebere album skupine
	 * @param {int} ID alba
	 * @return Bool
	 */
	public function odebratAlbum($idAlba) {
		return false;
	}

	/**
     * Vrati kolekci alb, ktera patri skupine
     * @return Alba
	 */
	public function seznamAlb() {
		return false;
	}
}

/**
 * Třída pro práci s modely typu Skupina
 * @class Skupiny
 */
class Skupiny extends LapiCollection {
	public $db_table = 'Skupiny';
	public $model = 'Skupina';
}