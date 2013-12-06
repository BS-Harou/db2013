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
		/** 
		 * @attribute id_Skupiny
		 */
		'id_Skupiny'    => NULL,

		/** 
		 * @attribute nazev
		 */
		'nazev'         => NULL,

		/** 
		 * @attribute rok_zalozeni
		 */
		'rok_zalozeni'  => 0,

		/** 
		 * @attribute historie
		 */
		'historie'      => '',

		/** 
		 * @attribute www
		 */
		'www'           => '',

		/** 
		 * @attribute foto
		 */
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
	 * @method pridatAlbum
	 * @param {int} ID alba
	 * @return Bool
	 */
	public function pridatAlbum($idAlba) {
		return false;
	}

	/**
	 * Odebere album skupine
	 * @method odebratAlbum
	 * @param {int} ID alba
	 * @return Bool
	 */
	public function odebratAlbum($idAlba) {
		return false;
	}

	/**
     * Vrati kolekci alb, ktera patri skupine
     * @method seznamAlb
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