<?php

/**
 * Třída pro tvorbu modelů typu Skladba
 * @class Skladba
 */
class Skladba extends LapiModel {
	public $idAttribute = 'id_Skladby';
	public $defaults = array(
		/** 
		 * @attribute id_Skladby
		 */
		'id_Skladby'   => NULL,

		/** 
		 * @attribute nazev
		 */
		'nazev'        => '',

		/** 
		 * @attribute text
		 */
		'text'         => '',

		/** 
		 * @attribute youtube
		 */
		'youtube'      => '',

		/** 
		 * @attribute delka
		 */
		'delka'        => '',

		/** 
		 * @attribute id_Alba
		 */
		'id_Alba'      => NULL,
	);

	public $db_table = 'Skladby';

	/**
	 * Nastavi id alba
	 * @method pridatSkladbuKAlbu
	 * @param {Album|Int} ID nebo model alba
	 * @return Bool
	 */
	public function pridatSkladbuKAlbu($album) {
		if (is_numeric($album)) {
			$this->set('id_Alba', $idAlba);	
		} else if ($album instanceof LapiModel) {
			$this->set('id_Alba', $album->getId());
		} else {
			return false;
		}
		
		return $this->save();
	}

}

/**
 * Třída pro práci s modely typu Skladba
 * @class Skladby
 */
class Skladby extends LapiCollection {
	public $db_table = 'Skladby';
	public $model = 'Skladba';
}