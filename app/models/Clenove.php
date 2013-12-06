<?php

require_once($app->dirModels . '/Nastroj.php');
require_once($app->dirModels . '/ClenoveJoinNastroje.php');

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

	/**
	 * Prida nastroj k clenovi
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


class Clenove extends LapiCollection {
	public $db_table = 'Clenove';
	public $model = 'Clen';
}