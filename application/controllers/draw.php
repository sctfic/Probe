<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Draw extends CI_Controller {
/**
Cette classe appelle les differentes requetes
en vu de les retourner au scripte ajax qui les dessinera
*/

	protected $Station=NULL; // name or ID nbr of station
	protected $sensors=NULL; // name or ID nbr of station
	protected $Since=NULL; // start date of data
	protected $StepUnit='HOUR'; // HOUR, DAY, WEEK, MONTH, (YEAR)
	protected $StepNbr=12; // number of step 1-48
	public $dataReader=NULL;

	function __construct() {
		parent::__construct();
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		
		include_once(BASEPATH.'core/Model.php'); // need for load models manualy
		include_once(APPPATH.'models/station.php');
		include_once(APPPATH.'models/dao/dao_data.php');
		include_once(APPPATH.'models/dao/dao_data_summary.php');

		$this->load->helper('download');

		$this->station = new Station();
		// print_r($this->input->get());
		// encoded with javascript encodeURIComponent()
		$station = rawurldecode($this->input->get('station'));

		$this->setSensors($this->input->get('sensors'));
		// $this->Size = $this->input->get('Size');
		$this->Since = rawurldecode($this->input->get('Since'));
		$this->StepUnit = $this->input->get('StepUnit');
		$this->StepNbr = $this->input->get('StepNbr');

		if (empty($this->Since) || empty($this->StepUnit) || empty($this->StepNbr)) {
			$this->Since = date('Y/m/d H:i:s', strtotime(date('Y/m/d 00:00:00')) - 365*24*60*60); // today - 365 days
			$this->StepUnit = 'DAY';
			$this->StepNbr = 365; // 365
		}

		$this->Station = end($this->station->config($station));
		// print_r($this->Station);
		$this->info = array("info"=>array(
			"lat"=>$this->Station['Geo:Latitude:NordValue'],
			"lon"=>$this->Station['Geo:Longitude:EstValue'],
			"alt"=>$this->Station['Geo:Elevation:Ocean'],
			"name"=>$this->Station['_name'],
			"id"=>$this->Station['_name']));

		if ($this->Since or $this->StepUnit or $this->StepNbr) {
			$this->dataReader = new dao_data($this->Station);
			// $this->load->model('dao/dao_data', 'dataReader'); // return $this->dataReader object
		}
		else {
			$this->dataReader = new dao_data_summary($this->Station);
			// $this->load->model('dao/dao_data_summary', 'dataReader'); // return $this->dataReader object
		}

	}
	function setSensors($str) {
		$this->sensors = explode(',', rawurldecode($str), 16+1);
		if (isset($this->sensors[16])) unset($this->sensors[16]);
		return $this->sensors;
	}
/**

* @
* @param 
* @param 
*/
	function index(){
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

		// header("Content-Type: application/json");
		// echo ($this->windRose());
		// $data = $this->windRose();
		// ob_clean();
		// header_remove();
		// force_download('data.json', '{"info":["lon":0,"lat":0,"name":"name","id":"id"],"data":'.$data.'}');
	}

/**

* @
* @param since is the start date of result needed
* @param lenght is the number of day
* @param is the sensor name (one or more)
*/
	function curve(){
		$data = $this->dataReader->curve (
			$this->station->get_TABLE_Dest($this->sensors),
			$this->sensors,
			$this->Since,
			$this->StepUnit,
			$this->StepNbr
		);
		$this->dl_csv ($data);
	}
/**

* @
* @param since is the start date of result needed
* @param lenght is the number of day
* @param is the sensor name (one or more)
*		 for each we return by period :
*			[first period value,
*			min period value,
*			avg period value,
*			max period value,
*			last period value]
*/
	function bracketCurve(){
		$data = $this->dataReader->curve (
			$this->station->get_TABLE_Dest($this->sensors),
			$this->Since,
			$this->StepUnit,
			$this->StepNbr
		);
		$this->dl_json ($data);
	}
/**
http://probe.dev/draw/windrose?station=VP2_GTD&sensors=TA:Arch:Temp:Out:Average&Since=2012-10-26T00:00:00&StepUnit=DAY&StepNbr=6
* @
* @param since is the start date of result needed
* @param lenght is the number of day
*/
	function wind(){
		$data = $this->dataReader->wind ($this->Since, $this->StepUnit, $this->StepNbr);
		$this->dl_json ($data);
	}

	private function dl_json ($data) {
		$json = json_encode(array_merge($this->info, array('data' => $data)), JSON_NUMERIC_CHECK);
		// ob_clean();
		@ob_end_clean();
		header_remove();
		force_download('data.json', $json);
	}
	private function dl_csv ($data) {
		$csv = str_putcsv(array_merge($this->info, array('data' => $data)), JSON_NUMERIC_CHECK);
		// ob_clean();
		@ob_end_clean();
		header_remove();
		force_download('data.csv', $csv);
	}
}