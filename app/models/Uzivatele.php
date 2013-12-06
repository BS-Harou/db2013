<?php

require_once($app->dirModels . '/Zadosti.php');

class Uzivatel extends LapiModel {
	public $idAttribute = 'id_Uzivatele';
	public $defaults = array(
		'id_Uzivatele'  => NULL,
		'nickname'      => NULL,
		'jmeno'         => '',
		'prijmeni'      => '',
		'icq'           => '',
		'heslo'         => '',
		/*'datum_registrace' => NULL, // commented to get current timestamp */
		'mail'          => '',
		'id_Role'       => 1 // 1 = basic user
	);

	public $db_table = 'Uzivatele';

	/**
	 * Zmeni heslo na nove (je-li vse v poradku)
	 * @param {String} Stare heslo
	 * @param {String} Nove heslo
	 * @param {String} Potvrzeni noveho hesla
	 * @return Bool
	 */
	public function zmenitHeslo($oldPass, $newPass, $confirmPass) {
		if ($newPass != $confirmPass) return false;
		if (strlen($newPass) < 5) return false;
		
		$oldPass = md5($oldPass);
		if ($oldPass != $this->get('heslo')) return false;

		$newPass = md5($newPass);
		$this->set('heslo', $newPass);
		return $this->save();
	}

	/**
	 * Prida zadost o mod. prava. Administrator ji musi jeste potvrdit.
	 * @return Bool
	 */
	public function zazadatModPrava() {
		$novaZadost = new Zadost(array(
			'id_Uzivatele' => $this->get('id_Uzivatele'),
			'datum' => date('c')
		));

		return $novaZadost->save();
	}

	/**
	 * Nastavi roli uzivatele zpet na bezneho uzivatele
	 * @return Bool
	 */
	public function vratitRoliUzivatele() {
		$this->set('id_Role', 1);
		return $this->save();
	}
}


class Uzivatele extends LapiCollection {
	public $db_table = 'Uzivatele';
	public $model = 'Uzivatel';
}