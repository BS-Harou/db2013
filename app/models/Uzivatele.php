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
		'mail'          => ''
	);

	public $db_table = 'Uzivatele';

	public function zmenitHeslo($oldPass, $newPass, $confirmPass) {
		if ($newPass != $confirmPass) return false;
		if (strlen($newPass) < 5) return false;


		

		
		$oldPass = md5($oldPass);
		if ($oldPass != $this->get('heslo')) return false;

		$newPass = md5($newPass);
		$this->set('heslo', $newPass);
		return $this->save();
	}

	public function zazadatModPrava() {
		$novaZadost = new Zadost(array(
			'Uzivatele_id_Uzivatele' => $this->get('id'),
			'datum' => date('dd.mm.yy')
		));

		$novaZadost->save();
	}
}


class Uzivatele extends LapiCollection {
	public $db_table = 'Uzivatele';
	public $model = 'Uzivatel';
}