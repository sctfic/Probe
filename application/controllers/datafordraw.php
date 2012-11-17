<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dataForDraw extends CI_Controller {
/**
Cette classe appelle les differentes requetes
en vu de les retourner au scripte ajax qui les dessinera
*/

	protected $ActiveStation=NULL; // name or ID nbr of station
	protected $Since=NULL; // start date of data
	protected $StepUnit=NULL; // HOUR, DAY, WEEK, MONTH, (YEAR)
	protected $StepNbr=NULL; // number of step 1-48
	protected $Size=NULL; // micro or big


	function __construct() {
		parent::__construct();
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		
		include_once(BASEPATH.'core/Model.php'); // need for load models manualy
		include_once(APPPATH.'models/station.php');
		$this->station = new Station();

		$Station = $this->input->post('ActiveStation');
		$this->Size = $this->input->post('Size');
		if ($this->Size!='micro') {
			$this->Since = $this->input->post('Since');
			$this->StepUnit = $this->input->post('StepUnit');
			$this->StepNbr = $this->input->post('StepNbr');
		}

		$this->ActiveStation = $this->station->config($Station);

		$this->load->model($Size.'draw', 'drawer'); // return $this->drawer object

	}

/**

* @
* @param 
* @param 
*/
	function index(){
		echo $Size;
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

* @
* @param since is the start date of result needed
* @param lenght is the number of day
*/
	function windrose(){
		$data = $this->drawer->windrose ($this->Since, $this->StepUnit, $this->StepNbr);
		$json = json_encode($data);
		return $json;
	}
/**

* @
* @param since is the start date of result needed
* @param lenght is the number of day
*/
	function windrose_allInOne($since, $lenght){

	}
}