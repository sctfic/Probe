<?php
// http://fmaz.developpez.com/tutoriels/php/comprendre-pdo/
class dbdata extends CI_Model {
// http://www.codeigniter.fr/user_guide/database/connecting.html
	protected $prep_EAV = NULL;
	protected $prep_SENSOR = NULL;
	protected $prep_ROW = NULL;
	protected $DB = NULL;

	function __construct($base)
	{
		log_message('debug',  '__construct() '.__FILE__);
		parent::__construct();
		$DB = $this->load->database($base, TRUE);
		$this->prep_EAV = $this->db->conn_id->prepare('REPLACE INTO :table (ID, VALUE, SEN_ID) VALUES (:utc, :val, :sensorID);');
		$this->prep_SENSOR = $this->db->conn_id->prepare('REPLACE INTO `TR_SENSOR` (SEN_ID, , ) VALUES (:sensorID, :name, :descript, :min, :max, :error, :unit);');
		$this->prep_ROW = $this->db->conn_id->prepare('REPLACE INTO `TA_VARIOUS` (, , ) VALUES ();');
	}
	function parse_Data(){
	
	}
	function insert_Data(){

	}
	function insert_EAV() {
		$this->prep_EAV->execute(array(':table'=>$value, ':utc'=>$value, ':val'=>1, ':sensorID'=>1));
		
	}
	function insert_SENSOR() {
		$this->prep_SENSOR->execute(array('sensorID'=>, 'name'=>, 'descript'=>, 'min'=>, 'max'=>, 'error'=>, 'unit'=>));
		
	}
	function insert_ROW() {
		
	}
	function get_Last_Date() {
		$date = $this->db->query('SELECT MAX( VAR_ID ) FROM  `TA_VARIOUS` LIMIT 10';
		if (count(result_array($date))==1)
			return $date->VAR_ID;
		print_r($date);

		log_message('db', "");
	}
}