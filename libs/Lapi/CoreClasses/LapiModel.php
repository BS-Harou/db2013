<?php



class LapiModel {
	public $attributes = array();
	public $idAttribute = 'id';
	public $defaults = array();
	public $cid = '';
	public $validationError = '';
	public $db_table;
	public static $_idCounter = 0;
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
	private static function uniqueId($prefix) {
		$id = ++self::$_idCounter . '';
		return $prefix ? $prefix . $id : $id;
	}
	public function fillDefaults() {
		foreach ($this->defaults as $key => $value) {
			if (!$this->has($key)) {
				$this->set($key, $value);
			}
		}
	}
	public function get($index) {
		return $this->has($index) ? $this->attributes[$index] : NULL;
	}
	public function escape($index) {
		return $this->has($index) ? htmlspecialchars($this->attributes[$index]) : NULL;
	}
	public function set($index, $value) {
		return $this->attributes[$index] = $value;
	}
	public function remove($index) {
		unset($this->attributes[$index]);
	}
	public function has($index) {
		return isset($this->attributes[$index]);
	}
	public function clear() {
		$this->attributes = array();
	}
	public function getId() {
		return $this->get($this->idAttribute);
	}
	public function setId($value) {
		return $this->set($this->idAttribute, $value);
	}
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
		} else {
			$rt = !!$app->db->update($this->db_table, $this->attributes, array(
				'where' => array(
					$this->idAttribute => $this->getId()
				),
				'limit' => '1'
			));
		}

		if (!$rt) {
			throw new Exception('LapiModel Error. Can\'t save model to MySQL');
		}

		return true;
	}
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

		foreach ($data as $key => $value) {
			$this->set($key, $value);
		}
		
		return true;
	}
	public function destroy($attr) {
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
	public function validate() {
		return 0;
	}
	public function isValid() {
		$this->validationError = $this->validate();
		return !$this->validationError;
	}
	public function parse($store) {
		foreach($store as $key => $value) {
			$this->set($key, $value);
		}
	}
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
	public function pick($arr) {
		$rt = array();

		for ($i=0; $i < count($arr); $i++) {
			if ($this->has($arr[$i])) {
				$rt[ $arr[$i] ] = $this->get( $arr[$i] );
			}
		}

		return $rt;
	}
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
	public function keys() {
		$rt = array();
		foreach($this->attributes as $key => $value) {
			$rt[] = $key;
		}
		return $rt;
	}
	public function values() {
		$rt = array();
		foreach($this->attributes as $key => $value) {
			$rt[] = $value;
		}
		return $rt;
	}
	public function pairs() {
		$rt = array();
		foreach($this->attributes as $key => $value) {
			$rt[] = array($key, $value);
		}
		return $rt;
	}
}