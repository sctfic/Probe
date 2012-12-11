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

		$this->Station = end($this->station->config($station));

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
		$data = $this->windRose();
		ob_clean();
		header_remove();
		force_download('data.json', '{"infos":[],"data":'.$data.'}');
	}

/**

* @
* @param since is the start date of result needed
* @param lenght is the number of day
* @param is the sensor name (one or more)
*/
	function curves(){
		
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
		
	}

/**
http://probe.dev/draw?station=VP2_GTD&sensors=TA:Arch:Temp:Out:Average&Since=2012-10-26T00:00:00&StepUnit=DAY&StepNbr=6
* @
* @param since is the start date of result needed
* @param lenght is the number of day
*/
	function windRose(){
		$data = $this->dataReader->windrose ($this->Since, $this->StepUnit, $this->StepNbr);
		$json = json_encode($data);
		return $json;
	}
/**

* @
* @param since is the start date of result needed
* @param lenght is the number of day
*/
	function windRose_allInOne($since, $lenght){

	}
}