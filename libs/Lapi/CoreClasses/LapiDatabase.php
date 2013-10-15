<?php

/**
 * Třídá pro práci s databází
 * @class LapiDatabase
 */
class LapiDatabase {

	/**
	 * Přihlašovací jméno k databázi
	 * @type String
	 */
	private $username;

	/**
	 * Přihlašovací heslo k databázi
	 * @type String
	 */
	private $password;

	/**
	 * database host
	 * @type String
	 */
	private $host;

	/**
	 * Název databáze
	 * @type String
	 */
	private $database;

	/**
	 * Reference na MySQLi objekt
	 * @type MySQLI
	 */
	public  $mysqli;

	/**
	 * Info. jestli jsme připojeni k databázi
	 * @type String
	 */
	public  $isConnected = false;

	/**
	 * Konstruktor
	 * @param $u {String} Uživ. jméno k db
	 * @param $p {String} Uživ. heslo k db
	 * @param $h {String} Db host
	 * @param $d {String} Název databáze
	 */
	public function __construct($u, $p, $h, $d) {
		$this->username = $u;
		$this->password = $p;
		$this->host = $h;
		$this->database = $d;
	}

	/**
	 * Obecný dotaz na databázi
	 * @param $q {String} Dotaz
	 * @return Object (MySQLi result)
	 * @example $db->query('SELECT * FROM tabulka')
	 */
	public function query($q) {
		if (!$this->isConnected) {
			$this->realConnect();
		}
		return $this->mysqli->query($q);
	}

	/**
	 * SELECT dotaz na databázi
	 * @param $table {String} Název tabulky
	 * @param $attr {Array} Parametry
	 * @return Object (MySQLi result)
	 */
	public function select($table, $attr=array()) {

		$q = 'SELECT SQL_CALC_FOUND_ROWS * FROM `' . $this->escape($table) . '`';
		if (isset($attr['where'])) $q .= self::parseWhere($attr['where']);
		if (isset($attr['order'])) $q .= ' ORDER BY ' . $attr['order'];
		if (isset($attr['limit'])) $q .= ' LIMIT ' . $attr['limit'];


		return $this->query($q);
	}

	/**
	 * DELETE dotaz na databázi
	 * @param $table {String} Název tabulky
	 * @param $attr {Array} Parametry
	 * @return Object (MySQLi result)
	 */
	public function delete($table, $attr=array()) {
		$q = 'DELETE FROM `' . $this->escape($table) . '`';
		if (isset($attr['where'])) $q .= self::parseWhere($attr['where']);
		if (isset($attr['limit'])) $q .= ' LIMIT ' . $attr['limit'];

		return $this->query($q);
	}

	/**
	 * INSERT dotaz na databázi
	 * @param $table {String} Název tabulky
	 * @param $attr {Array} Parametry
	 * @return Object (MySQLi result)
	 */
	public function insert($table, $data, $attr=NULL) {
		$sqlStringA = '';
		$sqlStringB = '';

		foreach ($data as $key => $value) {			
			$sqlStringA .= '`' . $this->escape($key) . '`,';
			$sqlStringB .= '"' . $this->escape($value) . '",';
		}
		$sqlStringA = preg_replace('/,$/', '', $sqlStringA);
		$sqlStringB = preg_replace('/,$/', '', $sqlStringB);

		$q = 'INSERT INTO `' . $this->escape($table) . '` (' . $sqlStringA . ') VALUES(' . $sqlStringB . ')';

		return $this->query($q);
	}

	/**
	 * UPDATE dotaz na databázi
	 * @param $table {String} Název tabulky
	 * @param $attr {Array} Parametry
	 * @return Object (MySQLi result)
	 */
	public function update($table, $data, $attr=NULL) {
		$sqlString = '';

		foreach ($data as $key => $value) {			
			$sqlString .= '`' . $this->escape($key) . '`="' . $this->escape($value) . '",';
		}
		$sqlString = preg_replace('/,$/', '', $sqlString);

		$q = 'UPDATE `' . $this->escape($table) . '` SET ' . $sqlString;
		if (isset($attr['where'])) $q .= self::parseWhere($attr['where']);
		if (isset($attr['limit'])) $q .= ' LIMIT ' . $attr['limit'];


		return $this->query($q);
	}

	/**
	 * Debugovací funkce která vypíše info o mysqli objektu
	 */
	public function dump() {
		var_dump($this->mysqli);
	}

	/**
	 * Escapování řetězce
	 * @param $str {String} Řetězec který má být escpaován
	 * @return String
	 */
	public function escape($str) {
		return mysql_escape_string($str);
	}

	/**
	 * K db. se nepřipojíme hned při vytovření instance LapiDatabase, ale až při prvním dotazu.
	 * Tato funkce se stará o skutečné připojení k db
	 */
	private function realConnect() {
		$this->mysqli = new Mysqli($this->host, $this->username, $this->password, $this->database);
		$this->isConnected = $this->mysqli->connect_errno === 0 ? true : false;
	}

	/**
	 * SELECT, UPDATE, DELETE dotazy umožňují nastavit parametr WHERE
	 * Ten buď může být SQL řetězec nebo asociativní pole
	 * Pokud je to ascc. pole, tak např array('where' => array('name' => 'Jan Novak', 'age' => 27))
	 * se převede na WHERE `name`='Jan Novak' AND `age`='27'
	 * Funkce se navíc postará o to, aby všechny vstupy byly escapováný (v případě asoc. pole)
	 */
	static function parseWhere($arr) {
		if (is_string($arr)) {
			return ' WHERE ' . $arr;
		} else if (!is_array($arr) || count($arr) == 0) {
			return;
		}

		global $app;
		$str = ' WHERE ';
		foreach ($arr as $key => $value)  {
			$str .= '`' . $app->db->escape($key) . '`="' . $app->db->escape($value) . '" AND ';
		}
		$str = preg_replace('/\sAND\s$/', '', $str);

		return $str;
	}
}