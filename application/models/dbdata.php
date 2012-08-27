<?php
// http://fmaz.developpez.com/tutoriels/php/comprendre-pdo/
class dbdata extends CI_Model {
// http://www.codeigniter.fr/user_guide/database/connecting.html
	
	protected $prep_EAV = NULL;
	protected $key_EAV = array(':table', ':id', ':val', ':sensorID');

	protected $prep_SENSOR = NULL;
	protected $key_SENSOR = array(':ID', ':NAME', ':HUMAN_NAME', ':DESCRIPT', ':MIN_REAL', ':MAX_REAL', ':UNITE_SIGN', ':DEF_PLOT', ':MAX_ALARM', ':MIN_ALARM', ':LAST_CALIBRATE', ':CALIBRATE_PERIOD');

	protected $prep_VARIOUS = NULL;
	protected $key_VARIOUS = array(':DATE', ':rainfall', ':max_rainfall', ':pressure', ':srad', ':max_srad', ':wspeed', ':max_wspeed', ':dir_higtspeed', ':dir_dominant', ':uv', ':max_uv', ':forcast', ':rain');
	
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
				VALUES (:id, :val, :sensorID);');
		$this->prep_SENSOR = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO `TR_SENSOR` 
					(SEN_ID, SEN_NAME, SEN_HUMAN_NAME, SEN_DESCRIPTIF, SEN_MIN_REALISTIC, SEN_MAX_REALISTIC, SEN_UNITE_SIGN, SEN_DEF_PLOT, SEN_MAX_ALARM, SEN_MIN_ALARM, SEN_LAST_CALIBRATE, SEN_CALIBRATE_PERIOD) 
				VALUES ('.implode(', ', $this->key_SENSOR).');');
		$this->prep_VARIOUS = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO `TA_VARIOUS` 
					(`VAR_DATE`, `VAR_SAMPLE_RAINFALL`, `VAR_SAMPLE_RAINFALL_HIGHT`, `VAR_PRESSURE`, `VAR_SOLAR_RADIATION`, 
					`VAR_SOLAR_RADIATION_HIGHT`, `VAR_WIND_SPEED`, `VAR_WIND_SPEED_HIGHT`, `VAR_WIND_SPEED_HIGHT_DIR`, 
					`VAR_WIND_SPEED_DOMINANT_DIR`, `VAR_UV_INDEX`, `VAR_UV_INDEX_HIGHT`, `VAR_FORECAST_RULE`, `VAR_ET`)
				VALUES ('.implode(', ', $this->key_VARIOUS).');');
	}
	function save_Archive($data){
		$this->current_data = $data;
		$this->parse_Data();
		$this->insert_VARIOUS(array(
			$data['TA:Arch:Various:Time:UTC'], 
			$data['TA:Arch:Rain:RainFall:Sample'], 
			$data['TA:Arch:Rain:RainRate:HighSample'], 
			$data['TA:Arch:Various:Bar:Current'], 
			$data['TA:Arch:Various:Solar:Radiation'], 
			$data['TA:Arch:Various:Solar:HighRadiation'], 
			$data['TA:Arch:Various:Wind:SpeedAvg'], 
			$data['TA:Arch:Various:Wind:HighSpeed'], 
			$data['TA:Arch:Various:Wind:HighSpeedDirection'], 
			$data['TA:Arch:Various:Wind:DominantDirection'], 
			$data['TA:Arch:Various:UV:IndexAvg'], 
			$data['TA:Arch:Various:UV:HighIndex'], 
			$data['TA:Arch:Various::ForecastRule'],
			$data['TA:Arch:Various:ET:Hour'], 
			));
		$date = $this->dataDB->query('SELECT VAR_ID FROM TA_VARIOUS WHERE VAR_DATE=`'.$data['TA:Arch:Various:Time:UTC'].'` LIMIT 10');
		if (count($date->result_array())==1) {
			$id = end($date->result_array[0]);
		}
		
		foreach ($data as $name => $val) {
			if (($table = $this->get_TABLE_Dest($name)) != 'TA_VARIOUS') {
				$sensor = $this->get_SEN_ID($name);
				$this->insert_EAV(array($table, $id, $val, $sensor));
			}
		}
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
	function get_TABLE_Dest($name) {
		if (strpos($name, ':Hum:'); !== false) return 'TA_HUMIDITY';
		elseif (strpos($name, ':Temp:'); !== false) return 'TA_TEMPERATURE';
		elseif (strpos($name, ':LeafWetnesses:'); !== false) return 'TA_WETNESSES';
		elseif (strpos($name, ':SoilMoisture:'); !== false) return 'TA_MOISTURE';
		else  return 'TA_VARIOUS';
	}
	function get_SEN_ID($name) {
		$id = $this->dataDB->query('SELECT SEN_ID FROM `TR_SENSOR` WHERE SEN_NAME=`'.$name.'` LIMIT 10');
		if (count($id->result_array())==1) {
			return end($id->result_array[0]);
		}
		else if (count($id->result_array())==0) {
			$this->db->query('INSERT 
				INTO `TR_SENSOR` 
					(SEN_NAME, SEN_DEF_PLOT, SEN_MAX_ALARM, SEN_MIN_ALARM, SEN_LAST_CALIBRATE, SEN_CALIBRATE_PERIOD) 
				VALUES 
					(`'.$name.'`, `Default_Plot`, 1999, -199, `2012/01/01 00:00:00`, 600)');
			return get_SEN_ID($name);
		}
		log_message('warning', 'Trop de resultat : '.print_r($id));
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