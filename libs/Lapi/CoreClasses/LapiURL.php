<?php

/**
 * URL Parser
 * @class LapiURL
 */
class LapiURL {
	/**
	 * Sekce stránky
	 * @property section
	 * @type String
	 * @example ...cz/admin/users/15 => sekce = admin
	 */
	public $section = '';

	/**
	 * Zbytek url (mimo query string) rozdělený podle /
	 * @property params
	 * @type Array
	 * @example ...cz/admin/users/15 => params = array('users', '15')
	 */
	public $params = array();

	/**
	 * Query string uložený do asociativního pole
	 * @property qs
	 * @type Array
	 * @example ...cz/admin?subsection=users&count=15 => qs = array('subsection' => 'users', 'count' => 15)
	 */
	public $qs = array();

	/**
	 * Hash
	 * @property hash
	 * @type String
	 * @example ...cz/admin#xyz => hash = xyz
	 */
	public $hash = '';

	/**
	 * Konstruktor
	 * @param $str {String} Část url za doménami (si1.martinkadlec.eu !!/admin/users?xyz=abc#123!!)
	 */
	public function __construct($str='') {
		
		
		// hash
		$splitA = explode('#', $str, 2);
		$splitA = $splitA ? $splitA : array();
		$this->hash = $splitA[1];

		// query string
		$splitB = explode('?', $splitA[0], 2);
		$splitB = $splitB ? $splitB : array();
		$this->qs = self::parseQueryString($splitB[1]);


		// sekce
		$splitC = explode('/', $splitB[0]);
		$splicC = $splitC ? $splitC : array();

		$this->section = stripString(array_shift($splitC));

		// parametry
		$this->params = $splitC;
	}

	/**
	 * Statická funkce, která parsuje query string
	 * @method parseQueryString
	 * @static
	 * @param $str {String} query string
	 * @example LapiURL::parseQueryString('abc=1&xyz=2') => 'array('abc' => 1, 'xyz' => 2)
	 */
	public static function parseQueryString($str) {
		if (!$str || strlen($str) == 0) return array();

		$rt = array();
		$parts = explode('&', $str);
		for ($i=0, $j=count($parts); $i<$j; $i++) {
			$part = explode('=', $parts[$i]);
			$rt[$part[0]] = $part[1];
		}

		return $rt;
	}
}