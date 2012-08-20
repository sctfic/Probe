<?php
// http://fmaz.developpez.com/tutoriels/php/comprendre-pdo/
class dbdata extends CI_Model {
// http://www.codeigniter.fr/user_guide/database/connecting.html
	
	protected $prep_EAV = NULL;
	protected $key_EAV = array(':table', ':utc', ':val', ':sensorID');

	protected $prep_SENSOR = NULL;
	protected $key_SENSOR = array(':sensorID', ':name', ':descript', ':min', ':max', ':error', ':unit');

	protected $prep_VARIOUS = NULL;
	protected $key_VARIOUS = array(':id', ':rainfall', ':max_rainfall', ':pressure', ':srad', ':max_srad', ':wspeed', ':max_wspeed', ':dir_higtspeed', ':dir_dominant', ':uv', ':max_uv', ':forcast', ':rain');
	
	protected $dataDB = NULL;
	protected $current_data = NULL;
	

	function __construct($base)
	{
		parent::__construct();
		log_message('debug',  __FUNCTION__.'('.__CLASS__.' ('.$base.') ) '.__FILE__);
		$this->dataDB = $this->load->database($base, TRUE);
		$this->prep_EAV = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO :table 
					(ID, VALUE, SEN_ID) 
				VALUES (:utc, :val, :sensorID);');
		$this->prep_SENSOR = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO `TR_SENSOR` 
					(SEN_ID, , ) 
				VALUES (:sensorID, :name, :descript, :min, :max, :error, :unit);');
		$this->prep_VARIOUS = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO `TA_VARIOUS` 
					(`VAR_ID` ,`VAR_SAMPLE_RAINFALL` ,`VAR_SAMPLE_RAINFALL_HIGHT` ,`VAR_PRESSURE` ,`VAR_SOLAR_RADIATION` ,`VAR_SOLAR_RADIATION_HIGHT` ,`VAR_WIND_SPEED` ,`VAR_WIND_SPEED_HIGHT` ,`VAR_WIND_SPEED_HIGHT_DIR` ,`VAR_WIND_SPEED_DOMINANT_DIR` ,`VAR_UV_INDEX` ,`VAR_UV_INDEX_HIGHT` ,`VAR_FORECAST_RULE` ,`VAR_RAIN`)
				VALUES (:id, :rainfall, :max_rainfall, :pressure, :srad, :max_srad, :wspeed, :max_wspeed, :dir_higtspeed, :dir_dominant, :uv, :max_uv, :forcast, :rain);');
	}
	function save($data){
		$this->current_data = $data;
		$this->parse_Data();
		$this->insert_VARIOUS();
// 		$this->insert_EAV();
// 		$this->insert_EAV();
// 		$this->insert_EAV();
	}
	function parse_Data(){
	  $this->current_data;
	}
	function insert_Data(){

	}
	function insert_EAV($value_EAV) {
		$real_EAV = array_combine($this->key_EAV, $value_EAV);
		$this->prep_EAV->execute($real_EAV);
		
	}
	function insert_SENSOR($value_SENSOR) {
		$real_SENSOR = array_combine($this->key_SENSOR, $value_SENSOR);
		$this->prep_SENSOR->execute($real_SENSOR);
		
	}
	function insert_VARIOUS($value_VARIOUS) {
		$real_VARIOUS = array_combine($this->key_VARIOUS, $value_VARIOUS);
		$this->prep_SENSOR->execute($real_VARIOUS);

	}
	function get_Last_Date() {
		$date = $this->dataDB->query('SELECT MAX(VAR_ID) FROM  `TA_VARIOUS` LIMIT 10');
		if (count($date->result_array())==1) {
			return end($date->result_array[0]);
		}
		else if (count($date->result_array())==0) {
			return '2012/01/01 00:00:00';
		}
		log_message('warning', 'Trop de resultat : '.print_r($date));
	}
}