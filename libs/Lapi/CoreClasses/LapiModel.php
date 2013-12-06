<?php

/**
 * Třída reprezentující jeden řádek z databáze.
 * Jednotlivé buňky se získavají/nastavují přes metody get a set. ($model->set('name', 'Jan Novak'))
 * Aby se změny uložili do databáze je třeba zavolat metodu save ($model->save())
 * Buňkám v modelu budeme říkat _atributy_
 * @class LapiModel
 */
class LapiModel {
	/**
	 * Asociativní pole jednotlivých atributů. Všechny změny by se měli dělat pomocí metody set.
	 * @property attributes
	 * @type Array
	 */
	public $attributes = array();

	/**
	 * Název sloupce, který slouží jako PRIMARY KEY
	 * @property idAttribute
	 * @type String
	 */
	public $idAttribute = 'id';

	/**
	 * Výchozí hodnoty atributů, která se nastaví při vytvoření nového modelu.
	 * @property defaults
	 * @type Array
	 */
	public $defaults = array();

	/**
	 * Speciální ID které se nastaví ihned při vytvoření modelu bez toho aby byl model uložený do databáze.
	 * @property cid
	 * @type String
	 */
	public $cid = '';

	/**
	 * Tuto proměnnou nastavuje metoda validate na chybovou hlášku, pokud není model validní
	 * @property validationError
	 * @type String
	 */
	public $validationError = '';

	/**
	 * Název tabulky ke které model patří
	 * @property db_table
	 * @type String
	 * @example 'users'
	 */
	public $db_table;

	/**
	 * Speciální interní proměnná, která se používá k vygenerování cid
	 * @property _idCounter
	 * @static
	 */
	public static $_idCounter = 0;

	/**
	 * Konstruktor
	 * @param $data {Array} Asociativní pole dat, která se mají modelu nastavit
	 * @example new LapiModel(array('name' => 'Jan Novak', 'age' => 13));
	 */
	public function __construct($data=NULL) {
		if ($data != NULL) {
			foreach ($data as $key => $value) {
				$this->set($key, $value);
			}
		}

		$this->cid = self::uniqueId('c');
		$this->fillDefaults();

		if (method_exists($this, 'initialize')) {
			$this->initialize();
		}
	}

	/**
	 * Statická metoda, která vygeneruje nové cid
	 * @method uniqueId
	 * @static
	 * @param $prefix {String} Normálně se generují hodnoty od 1 do n. Pefix umožňuje před číslo vložit nějaký řětezec (m1-mn)
	 * @return String
	 */
	private static function uniqueId($prefix) {
		$id = ++self::$_idCounter . '';
		return $prefix ? $prefix . $id : $id;
	}

	/**
	 * Pokud modelu chybí nějaký atribut, který je definovaný v defaults, tak se použije hodnota nastavená v defaults.
	 * @method fillDefaults
	 */
	public function fillDefaults() {
		foreach ($this->defaults as $key => $value) {
			if (!$this->has($key)) {
				$this->set($key, $value);
			}
		}
	}

	/**
	 * Získá hodnotu atributu
	 * @method get
	 * @param $index {String} Název atributu (index asoc. pole atributů)
	 * @example $model->get('name') => 'Jan Novak'
	 * @return Any
	 */
	public function get($index) {
		return $this->has($index) ? $this->attributes[$index] : NULL;
	}

	/**
	 * Získá hodnotu atributu a převede všechny html tagy na řetězce
	 * @method escape
	 * @param $index {String} Název atributu
	 * @example $model->escape('popis') => '&lt;b&gt;tucny text&lt;/b&gt;'
	 * @return String
	 */
	public function escape($index) {
		return $this->has($index) ? htmlspecialchars($this->attributes[$index]) : NULL;
	}

	/**
	 * Nastaví hodnotu atributu
	 * @method set
	 * @param $index {String} Název atributu
	 * @param $value {String} Hodnota atributu
	 * @example $model->set('name', 'Jan Novak')
	 * @return Any
	 */
	public function set($index, $value) {
		return $this->attributes[$index] = $value;
	}

	/**
	 * Odstraní atribut
	 * @method remove
	 * @param $index {String} Název atributu
	 */
	public function remove($index) {
		unset($this->attributes[$index]);
	}

	/**
	 * Vrátí true nebo false podle toho zda model má daný atribut
	 * @method has
	 * @param $index {String} Název atributu
	 * @return Bool
	 */
	public function has($index) {
		return isset($this->attributes[$index]);
	}

	/**
	 * Odstraní všechny atributy
	 * @method clear
	 */
	public function clear() {
		$this->attributes = array();
	}

	/**
	 * Vrátí hodnotu atributu, který reprezentuje buňku s PRIMARY KEY
	 * @method getId
	 * @return Any
	 */
	public function getId() {
		return $this->get($this->idAttribute);
	}

	/**
	 * Nastaví hodnotu atributu, který reprezentuje buňku s PRIMARY KEY
	 * @method setId
	 * @param $value {Any} Hodnota
	 * @return Any
	 */
	public function setId($value) {
		return $this->set($this->idAttribute, $value);
	}

	/**
	 * Uloží model do databáze.
	 * Pokud id modelu v databázi neexistuje vytvoří se nový řádek.
	 * Pokud id modelu v databázi už existuje, tak se aktualizuje řádek s daným id.
	 * @method save
	 * @return Bool
	 * @throws
	 */
	public function save() {
		global $app;
		if (!isset($this->db_table)) {
			$this->validationError = 'MySQL error! Missing table name.';
			return false;
		} else if (!$this->isValid()) {
			return false;
		}

		if ($this->isNew()) {
			$rt = !!$app->db->insert($this->db_table, $this->attributes);
			if (!$this->getId()) {
				$this->setId($app->db->mysqli->insert_id);
			}
		} else {
			$rt = !!$app->db->update($this->db_table, $this->attributes, array(
				'where' => array(
					$this->idAttribute => $this->getId()
				),
				'limit' => '1'
			));
		}

		if (!$rt) {
			echo $app->db->mysqli->error . '\n\n';
			throw new Exception('LapiModel Error. Can\'t save model to MySQL');
		}

		return true;
	}

	/**
	 * Uloží do modelu data z databáze
	 * @method fetch
	 * @return Bool
	 */
	public function fetch() {
		global $app;
		if (!isset($this->db_table)) {
			return false;
		}

		$rt = $app->db->select($this->db_table, array(
			'where' => array(
				$this->idAttribute => $app->db->escape($this->getId())
			),
			'limit' => '1'
		));


		if (!$rt || $rt->num_rows == 0) {
			return false;
		}

		$data = $rt->fetch_object();

		$data = $this->parse($data);

		foreach ($data as $key => $value) {
			$this->set($key, $value);
		}
		
		return true;
	}

	/**
	 * Odstraní model z databáze
	 * @method destroy
	 * @return Bool
	 * @throws
	 */
	public function destroy($attr=array()) {
		global $app;
		if (!isset($this->db_table) || !$this->getId()) {
			return false;
		}

		$wh = array($this->idAttribute => $this->getId());
		if (isset($attr['where']) && is_array($attr['where'])) {
			$wh = array_merge($attr['where'], $wh);
		} else if (isset($attr['where']) && is_string($attr['where']) && strlen($attr['where']) > 0) {
			$wh = $attr['where'] . ' AND `' . $app->db->escape($this->idAttribute) . '`="' . $app->db->escape($this->getId()) . '"';
		}

		$rt = !!@$app->db->delete($this->db_table, array(
			'where' => $wh,
			'limit' => '1'
		));

		if (!$rt) {
			throw new Exception('LapiModel Error. Can\'t remove model from MySQL');
		}

		return true;
	}

	/**
	 * Funkce, kterou můžou přepsat třídy dědící z této.
	 * Funkce buď vrátí nulu, jako že je vše v přoádku. Nebo řetězec obsahující chybovou zprávu.
	 * Tuto funkci využívá metoda isValid
	 * @method validate
	 * @return String|Integer
	 */
	public function validate() {
		return 0;
	}

	/**
	 * Zkontroluje zda je model validní.
	 * Pokud není přepsaná metoda validate, tak je model validní vždy
	 * @method isValid
	 * @return Bool
	 * @example if ( !$model->isValid() ) echo $model->validationError
	 */
	public function isValid() {
		$this->validationError = $this->validate();
		return !$this->validationError;
	}

	/**
	 * Běžně se uloží hodnoty z databáze rovnou do atributů, je ale možné přepsat metodu parse
	 * a tak data změnit dřív než se uloží do modelu.
	 * @param $store {Array|Object} Asoc. pole nebo objekt obsahující data z databáze
	 * @method parse
	 * @return Array|Object
	 */
	public function parse($store) {
		return $store;
		/*foreach($store as $key => $value) {
			$this->set($key, $value);
		}*/
	}

	/**
	 * Zjistí, jestli je model už v databázi
	 * @method isNew
	 * @return Bool
	 */
	public function isNew() {
		global $app;
		if ($this->getId() && strlen($this->getId()) > 0) {
			if (!isset($this->db_table)) {
				return false;
			}

			$rt = $app->db->select($this->db_table, array(
				'where' => array(
					$this->idAttribute => $this->getId()
				),
				'limit' => 1
			));
			return (!$rt || $rt->num_rows === 0);
		} 
		return true;
	}

	/**
	 * Vrátí pole pouze specifikovaných atributů
	 * @method pick
	 * @param $arr {Array} Pole názvů atributů, která chceme
	 * @return Array
	 * @example $model->pick(array('name', 'age')) => array('name' => 'Jan Novak', 'age' => 27)
	 */
	public function pick($arr) {
		$rt = array();

		for ($i=0; $i < count($arr); $i++) {
			if ($this->has($arr[$i])) {
				$rt[ $arr[$i] ] = $this->get( $arr[$i] );
			}
		}

		return $rt;
	}

	/**
	 * Vrátí pole všech atribůtů, kromě těch které jsou specifikovány
	 * @method omit
	 * @param $arr {Array} Pole názvů atributů, která nechceme
	 * @return Array
	 * @example $model->omit(array('name')) => array('age' => 27, 'mail' => 'jan.novak@mail.cz')
	 */
	public function omit($arr) {
		$rt = array();
		$keys = $this->keys();

		for ($i=0; $i < count($keys); $i++) {
			if (!in_array($keys[$i], $arr)) {
				$rt[ $keys[$i] ] = $this->get( $keys[$i] );
			}
		}

		return $rt;
	}

	/**
	 * Vrátí pole názvů atributů
	 * @method keys
	 * @return Array
	 * @example $model->keys() => array('name', 'age', 'mail')
	 */
	public function keys() {
		$rt = array();
		foreach($this->attributes as $key => $value) {
			$rt[] = $key;
		}
		return $rt;
	}

	/**
	 * Vráti pole hodnot atributů
	 * @method values
	 * @return Array
	 * @example $model->keys() => array('Jan Novak', '27', 'jan.novak@mail.cz')
	 */
	public function values() {
		$rt = array();
		foreach($this->attributes as $key => $value) {
			$rt[] = $value;
		}
		return $rt;
	}

	/**
	 * Vrátí vícerozměrné pole atributů uspořadaných do dvojic název/hodnota
	 * @method pairs
	 * @return Array
	 * @example $model->pairs() => array(array('name', 'Jan Novak'), array('age', 27), array('mail', 'jan.novak@mail.cz'))
	 */
	public function pairs() {
		$rt = array();
		foreach($this->attributes as $key => $value) {
			$rt[] = array($key, $value);
		}
		return $rt;
	}
}