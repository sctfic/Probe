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
		$this->prep_ROW = $this->db->conn_id->prepare('REPLACE  INTO `TA_VARIOUS` 
			(`VAR_ID` ,`VAR_SAMPLE_RAINFALL` ,`VAR_SAMPLE_RAINFALL_HIGHT` ,`VAR_PRESSURE` ,`VAR_SOLAR_RADIATION` ,`VAR_SOLAR_RADIATION_HIGHT` ,`VAR_WIND_SPEED` ,`VAR_WIND_SPEED_HIGHT` ,`VAR_WIND_SPEED_HIGHT_DIR` ,`VAR_WIND_SPEED_DOMINANT_DIR` ,`VAR_UV_INDEX` ,`VAR_UV_INDEX_HIGHT` ,`VAR_FORECAST_RULE` ,`VAR_RAIN`)
			VALUES (:id, :rainfall, :max_rainfall, :pressure, :srad, :max_srad, :wspeed, :max_wspeed, :dir_higtspeed, :dir_dominant, :uv, :max_uv, :forcast, :rain);');
	}
	function parse_Data(){
	
	}
	function insert_Data(){

	}
	function insert_EAV() {
		$this->prep_EAV->execute(array(':table'=>$value, ':utc'=>$value, ':val'=>1, ':sensorID'=>1));
		
	}
	function insert_SENSOR() {
		$this->prep_SENSOR->execute(array('sensorID'=>0, 'name'=>'none', 'descript'=>'', 'min'=>0, 'max'=>100, 'error'=>255, 'unit'=>'%'));
		
	}
	function insert_ROW() {
		$this->prep_SENSOR->execute(array('id'=>0, 'rainfall'=>0, 'max_rainfall'=>0, 'pressure'=>1013, 'srad'=>1, 'max_srad'=>1, 'wspeed'=>1, 'max_wspeed'=>2, 'dir_higtspeed'=>1, 'dir_dominant'=>1, 'uv'=>1, 'max_uv'=>1, 'forcast'=>1, 'rain'=>0 ));

	}
	function get_Last_Date() {
		$date = $this->db->query('SELECT MAX( VAR_ID ) FROM  `TA_VARIOUS` LIMIT 10');
		if (count(result_array($date))==1)
			return end($date->VAR_ID);
		log_message('db', 'trop de resultat : '.print_r($date));
	}
}