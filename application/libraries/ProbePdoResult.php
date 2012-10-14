<?php

/**
 * Inspiré de la classe pdo_result de codeigniter
 * @author jerep6
 *
 */
class ProbePdoResult {
	
	/**
	 * Statement pdo résultant de la requete
	 * @var PDOStatement
	 */
	public $statement				= NULL;
	
	/**
	 * Tableau de résultat sous forme d'objet. Utile pour restituer directement le tableau.
	 * @var array
	 */
	private  $result_object			= array();
	
	
	/**
	 * Tableau de résultat sous forme de tableau.
	 * @var array
	 */
	private $result_array			= array();
	
	/**
	 * Tableau de résultat d'objet personnel
	 * @var array
	 */
	private $custom_result_object	= array();

	/**
	 * Number of rows in the result set
	 *
	 * @access	public
	 * @return	integer
	 */
	function rowCount() {
		return $this->statement->rowCount();
	}

	// --------------------------------------------------------------------

	/**
	 * Number of fields in the result set
	 *
	 * @access	public
	 * @return	integer
	 */
	function columnCount() {
		return $this->statement->columnCount();
	}

	// --------------------------------------------------------------------

	/**
	 * Field data
	 *
	 * Generates an array of objects containing field meta-data
	 *
	 * @access	public
	 * @return	array
	 */
	function fieldData() {
		$data = array();
	
		try {
			for($i = 0; $i < $this->num_fields(); $i++) {
				$data[] = $this->statement->getColumnMeta($i);
			}
			return $data;
		}
		catch (Exception $e) {
			if ($this->db->db_debug) {
				return $this->db->display_error('db_unsuported_feature');
			}
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Free the result
	 *
	 * @return	null
	 */
	function freeResult() {
		if (is_object($this->result_id)) {
			$this->result_id = FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Result - associative array
	 *
	 * Returns the result set as an array
	 *
	 * @access	private
	 * @return	array
	 */
	function fetchAssoc() {
		return $this->statement->fetch(PDO::FETCH_ASSOC);
	}

	// --------------------------------------------------------------------

	/**
	 * Result - object
	 *
	 * Returns the result set as an object
	 *
	 * @access	private
	 * @return	object
	 */
	function fetchObject() {	
		return $this->statement->fetchObject();
	}
	
	
	
	/**
	 * Query result.  Acts as a wrapper function for the following functions.
	 *
	 * @access	public
	 * @param	string	can be "object" or "array"
	 * @return	mixed	either a result object or array
	 */
	public function result($type = 'object') {
		if ($type == 'array') return $this->resultArray();
		else if ($type == 'object') return $this->resultObject();
		else return $this->customResultObject($type);
	}
	
	/**
	 * Query result.  "object" version.
	 *
	 * @access	public
	 * @return	object
	 */
	public function resultObject() {
		if (count($this->result_object) > 0) {
			return $this->result_object;
		}
	
		// Si pas de résultat
		if ($this->statement === FALSE OR $this->rowCount() == 0) {
			return NULL;
		}
		
		while ($row = $this->fetchObject()) {
			$this->result_object[] = $row;
		}
	
		return $this->result_object;
	}
	
	/**
	 * Retourne un tableau d'objet de tous les résultats de la requete
	 *
	 * @param class_name A string that represents the type of object you want back
	 * @return array of objects
	 */
	public function customResultObject($class_name) {
		if (array_key_exists($class_name, $this->custom_result_object)) {
			return $this->custom_result_object[$class_name];
		}
	
		if ($this->statement === FALSE OR $this->rowCount() == 0) {
			return NULL;
		}
	
		// add the data to the object
		$result_object = array();
	
		while ($row = $this->fetchObject()) {
			$object = new $class_name();
			
			// Parcours des propriété publiques
			foreach ($row as $key => $value) {
				$object->$key = $value;
			}
	
			$result_object[] = $object;
		}
	
		// return the array
		return $this->custom_result_object[$class_name] = $result_object;
	}
	
	/**
	 * Query result.  "array" version.
	 *
	 * @access	public
	 * @return	array
	 */
	public function resultArray() {
		if (count($this->result_array) > 0) {
			return $this->result_array;
		}
	
		// Si pas de resultat
		if ($this->statement === FALSE OR $this->num_rows() == 0) {
			return NULL;
		}
	
		while ($row = $this->fetchAssoc()) {
			$this->result_array[] = $row;
		}
	
		return $this->result_array;
	}
	
	
	
	/**
	 * Returns the "first" row
	 *
	 * @access	public
	 * @return	object
	 */
	public function firstRow($type = 'object') {
		$result = $this->result($type);
	
		if ($result == NULL) {
			return NULL;
		}
		return $result[0];
	}
	
	
	/**
	 * Query result.  Acts as a wrapper function for the following functions.
	 *
	 * @access	public
	 * @param	string
	 * @param	string	can be "object" or "array"
	 * @return	mixed	either a result object or array
	 */
	public function row($n = 0, $type = 'object') {	
		if ($type == 'object') return $this->rowObject($n);
		else if ($type == 'array') return $this->rowArray($n);
		else return $this->customRowObject($n, $type);
	}
	
	/**
	 * Returns a single result row - object version
	 *
	 * @access	public
	 * @return	object
	 */
	public function rowObject($n = 0) {
		$result = $this->resultObject();
	
		if ($result == NULL) {
			return NULL;
		}
		
		return $result[$n];
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Returns a single result row - array version
	 *
	 * @access	public
	 * @return	array
	 */
	public function rowArray($n = 0) {
		$result = $this->result_array();
	
		if (count($result) == 0) {
			return NULL;
		}
	
		return $result[$n];
	}
	
	/**
	 * Returns a single result row - custom object version
	 *
	 * @access	public
	 * @return	object
	 */
	public function customRowObject($n, $type) {
		$result = $this->customResultObject($type);
	
		if ($result == NULL) {
			return NULL;
		}
			
		return $result[$n];
	}

}


/* End of file pdo_result.php */
/* Location: ./system/database/drivers/pdo/pdo_result.php */