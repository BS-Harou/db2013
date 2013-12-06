<?php

require_once($app->dirModels . '/Zadosti.php');

/**
 * Třída pro tvorbu modelů typu Uzivatel
 * @class Uzivatel
 */
class Uzivatel extends LapiModel {
	public $idAttribute = 'id_Uzivatele';
	public $defaults = array(
		/** 
		 * @attribute id_Uzivatele
		 */
		'id_Uzivatele'  => NULL,

		/** 
		 * @attribute nickname
		 */
		'nickname'      => NULL,

		/** 
		 * @attribute jmeno
		 */
		'jmeno'         => '',

		/** 
		 * @attribute prijmeni
		 */
		'prijmeni'      => '',

		/** 
		 * @attribute icq
		 */
		'icq'           => '',

		/** 
		 * @attribute heslo
		 */
		'heslo'         => '',

		/**
		 * commented to get current timestamp
		 * @attribute datum_registrace
		 */
		/*'datum_registrace' => NULL,  */

		/** 
		 * @attribute mail
		 */
		'mail'          => '',

		/**
		 * 1 = basic user, 2 = mod., 3 = admin
		 * @attribute id_Role
		 */
		'id_Role'       => 1 
	);

	public $db_table = 'Uzivatele';

	/**
	 * Zmeni heslo na nove (je-li vse v poradku)
	 * @method zmenitHeslo
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
	 * @method zazadatModPrava
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
	 * @method vratitRoliUzivatele
	 * @return Bool
	 */
	public function vratitRoliUzivatele() {
		$this->set('id_Role', 1);
		return $this->save();
	}
}

/**
 * Třída pro práci s modely typu Uzivatel
 * @class Uzivatele
 */
class Uzivatele extends LapiCollection {
	public $db_table = 'Uzivatele';
	public $model = 'Uzivatel';
}