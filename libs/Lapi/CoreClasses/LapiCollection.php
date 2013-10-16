<?php

/**
 * Třída reprezentující kolekci stejného typu řádků z databáze
 * @class LapiCollection
 */
class LapiCollection {

	/**
	 * Název třídy modelu
	 * @type String
	 */
	public $model = 'LapiModel';

	/**
	 * Pole všech modelů v kolekci
	 * @type Array
	 */
	public $models = array();

	/**
	 * Název tabulky ke které kolekce patří
	 * @type String
	 * @example 'users'
	 */
	public $db_table;

	/**
	 * Konstruktor, zavolá metodu initialize (pokud existuje)
	 * @param $attr {Array} Pokud chcete rovnou stáhnout data z databáze při vytvoření modelu, tak zadejte pole parametrů
	 * @example new LapiCollection( array('where' => array('name' => 'Jan Novak'), 'limit' => 1) );
	 */
	public function __construct($params=NULL) {
		if (method_exists($this, 'initialize')) {
			$this->initialize();
		}
		if (is_array($params)) {
			$this->fetch($params);
		}
	}

	/**
	 * Přidá model do kolekce
	 * @param $obj {LapiModel|Array} Model či pole modelů, které se mají přidat do kolekce
	 */
	public function add($obj) {
		if (is_array($obj)) {
			for ($i=0; $i<count($obj); $i++) $this->models[] = $obj[$i];
		} else if ($obj instanceof LapiModel) {
			$this->models[] = $obj;
		}
	}

	/**
	 * Odebere model z kolekce
	 * @param $obj {LapiModel|Array} Model či pole modelů, které se mají z kolekce odebrat
	 */
	public function remove($obj) {
		if ($obj instanceof LapiModel) {
			for ($i=0; $i<count($this->models); $i++) {
				if ($this->models[$i] === $obj) {
					array_splice($this->models, $i, 1);
				}
			}
		} else if (is_array($obj)) {
			for ($i=0; $i<count($this->models); $i++) {
				if (in_array($this->models[$i], $obj)) {
					array_splice($this->models, $i, 1);
				}
			}
		}
	}

	/**
	 * Odebere všechny předchozí modely z kolekce a přidá nové
	 * @param $arr {Array} Pole nových modelů
	 */
	public function reset($arr) {
		$this->models = array();
		for ($i=0; $i<count($arr); $i++) {
			$this->add($arr[$i]);
		}
	}

	/**
	 * Vrátí model z kolekce podle jeho id nebo cid
	 * @param $id {String} id nebo cid modelu
	 * @return LapiModel
	 */
	public function get($id) {
		for ($i=0; $i<count($this->models); $i++) {
			if ($this->models[$i]->getId() === $id) return $this->models[$i];
		}
		for ($i=0; $i<count($this->models); $i++) {
			if ($this->models[$i]->cid === $id) return $this->models[$i];
		}
	}

	/**
	 * Vrátí model na daném indexu
	 * @param $index {Integer} Index modelu
	 * @return LapiModel
	 */
	public function at($index) {
		return $this->models[$index];
	}


	/**
	 * Vrátí počet modelů v kolekci
	 * @return Integer
	 */
	public function length() {
		return count($this->models);
	}

	/**
	 * Běžně se uloží hodnoty z databáze rovnou do atributů, je ale možné přepsat metodu parse
	 * a tak data změnit dřív než se uloží do modelů.
	 * @param $arr {Array} Asoc. pole obsahující data z databáze
	 * @return Array
	 */
	public function parse($arr) {
		return $arr;
	}

	/**
	 * Získá modely z databáze
	 * @param $attr {Array} Parametry pro filtrovaní
	 * @example $collection->fetch( array('where' => 'age < 20') );
	 */
	public function fetch($attr=array()) {
		global $app;

		if (!isset($this->db_table)) {
			return false;
		}

		$rt = $app->db->select($this->db_table, $attr);

		if (!$rt || $rt->num_rows === 0) {
			return false;
		}

		$final_data = array();

		while ($data = $rt->fetch_object()) {
			$final_data[] = $data;
		}

		$final_data = $this->parse($final_data);

		$this->models = array();

		for ($i=0; $i < count($final_data); $i++) {
			$this->models[] = new $this->model($final_data[$i]);
		}

		return true;
	}

	/**
	 * Vrátí počet všech řádků v databázi po zavolání fetch s limitem
	 * @return Integer
	 */
	public function allRowsCount() {
		global $app;

		if (!isset($this->db_table)) {
			return false;
		}

		$rt = $app->db->query('SELECT FOUND_ROWS() AS amount');

		if (!$rt) {
			return false;
		}

		$data = $rt->fetch_object();

		return $data->amount;
	}

	/**
	 * Vrátí pole hodnot daného atributu
	 * @param $str {String} Název atributu
	 * @return Array
	 * @example $collection->pluck('age') => array(27, 29, 30, 14, 18)
	 */
	public function pluck($str) {
		$rt = array();
		for ($i=0,$j=$this->length(); $i < $j; $i++) {
			$rt[] = $this->get($str);
		}
		return $rt;
	}

	/**
	 * Vrátí pole modelů, které odpovídají zadaným parametrům
	 * @param $attrs {Array} Parametry.
	 * @return Array
	 * @example $collection->where(array('name' => 'Jan Novak')) => array([LapiModel Object])
	 */
	public function where($attrs) {
		$rt = array();
		for ($i=0,$j=$this->length(); $i < $j; $i++) {
			foreach ($attrs as $key => $value) {
				if ($this->at($i)->get($key) != $attrs[$key]) {
					continue 2;
				}
			}
			$rt[] = $this->at($i);
		}
		return $rt;
	}

	/**
	 * Vrátí první model, které odpovídá zadaným parametrům
	 * @param $attrs {Array} Parametry.
	 * @return LapiModel
	 * @example $collection->findWhere(array('name' => 'Jan Novak')) => [LapiModel Object]
	 */
	public function findWhere($attrs) {
		for ($i=0,$j=$this->length(); $i < $j; $i++) {
			foreach ($attrs as $key => $value) {
				if ($this->at($i)->get($key) != $attrs[$key]) {
					continue 2;
				}
			}
			return $this->at($i);
		}
		return NULL;
	}

	/**
	 * Vytvoří nový model, přidá ho do kolekce a uloží do databáze
	 * @param $attrs {Array} Asoc. pole atributů
	 * @param $options {Array} Pole nastavení. Zatím jen položka 'wait', která pokud je true a model se nepodaří uložit do db, tak se nepřidá ani do kolekce
	 * @return LapiModel
	 */
	public function create($attrs, $options=array()) {
		if (!isset($this->model) || !$this->model || !is_string($this->model) || strlen($this->model) == 0) {
			return NULL;
		}

		$model = new $this->model($attrs);
		$is_saved = $model->save();
		if (!is_array($options) || !isset($options['wait']) || $options['wait'] != true || $is_saved == true) {
			$this->add($model);
		}
		return $model;
	}
}