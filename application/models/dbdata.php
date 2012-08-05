<?php
// http://fmaz.developpez.com/tutoriels/php/comprendre-pdo/
class dbdata extends CI_Model {
	protected $prep_EAV = NULL;
	protected $prep_SENSOR = NULL;
	protected $prep_ROW = NULL;

	function __construct()
	{
		log_message('debug',  '__construct() '.__FILE__);
		parent::__construct();
		$this->prep_EAV = $this->db->conn_id->prepare('REPLACE INTO `TR_` (, , ) VALUES (:utc, :val, :sensorID);');
		$this->prep_SENSOR = $this->db->conn_id->prepare('REPLACE INTO `TR_` (, , ) VALUES (:sensorID, :name, :descript, :min, :max, :error, :unit);');
		$this->prep_ROW = $this->db->conn_id->prepare('REPLACE INTO `TR_` (, , ) VALUES (:utc, :val, :sensor);');
	}
	function parse_Data(){
	
	}
	function insert_Data(){

	}
	function inset_EAV() {
		$this->prep_EAV->execute(array(':utc'=>$value,':val'=>1, ':sensorID'=>1));
		
	}
	function inset_SENSOR() {
		$this->prep_SENSOR->execute(array('sensorID'=>, 'name'=>, 'descript'=>, 'min'=>, 'max'=>, 'error'=>, 'unit'=>));
		
	}
	function insert_ROW() {
		
	}


}