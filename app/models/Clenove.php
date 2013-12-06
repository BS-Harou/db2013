<?php

require_once($app->dirModels . '/Nastroje.php');
require_once($app->dirModels . '/ClenoveJoinNastroje.php');

/**
 * Třída pro tvorbu modelů typu Clen
 * @class Clen
 */
class Clen extends LapiModel {
	public $idAttribute = 'id_Clenove';
	public $defaults = array(
		/** 
		 * @attribute id_Clenove
		 */
		'id_Clenove'     => NULL,

		/** 
		 * @attribute jmeno
		 */
		'jmeno'          => '',

		/** 
		 * @attribute prijmeni
		 */
		'prijmeni'       => '',

		/** 
		 * @attribute datum_narozeni
		 */
		'datum_narozeni' => '',

		/** 
		 * @attribute datum_umrti
		 */
		'datum_umrti'    => '',

		/** 
		 * @attribute misto_narozeni
		 */
		'misto_narozeni' => '',

		/** 
		 * @attribute historie
		 */
		'historie'       => '',

		/** 
		 * @attribute www
		 */
		'www'            => ''
	);

	public $db_table = 'Clenove';

	/**
	 * Prida nastroj k clenovi
	 * @method pridatNastroj
	 * @param {Nastroj|String|Int} ID, nazev nebo model nastroje
	 * @return Bool
	 */
	public function pridatNastroj($nastroj) {
		$id = 0;
		if (is_number($nastroj)) {
			$id = $nastroj;
		} else if (is_string($nastroj)) {
			$coll = new Nastroj(array(
				'where' => array(
					'nazev' => $nastroj
				)
			));

			if ($coll->length()) {
				$id = $coll->at(0)->getId();
			} else {
				$novyNastroj = new Nastroj(array(
					'nazev' => $nastroj
				));
				$novyNastroj->save();
				$id = $novyNastroj->getId();
			}
		} else if ($nastroj instanceof LapiModel) {
			$id = $nastroj->getId();
			if (!$id) return false;
		} else {
			return false;
		}

		if ($id == 0) return false;

		$cjn = new ClenJoinNastroj(array(
			'id_Nastroje'   => $id,
			'id_Clenove'   => $this->getId(),
		));
		return $cjn->save();
	}
}

/**
 * Třída pro práci s modely typu Clen
 * @class Clenove
 */
class Clenove extends LapiCollection {
	public $db_table = 'Clenove';
	public $model = 'Clen';
}