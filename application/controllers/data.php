<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Data extends CI_Controller {
/**
Cette classe appelle les differentes requetes
en vu de les retourner au scripte ajax qui les dessinera
*/

	protected $Station=NULL; // name or ID nbr of station
	protected $sensor=NULL; // name or ID nbr of station
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
		// encoded with javascript encodeURIComponent()
		$station = rawurldecode($this->input->get('station'));

		$this->setSensor($this->input->get('sensor'));

		$this->Since = rawurldecode($this->input->get('Since'));
	        $this->Since = empty($this->Since) ? '2013-01-01T00:00':date('Y-m-dTH:i', strtotime($this->Since));

		$this->To = $this->input->get('To');
	        $this->To = empty($this->To) ? '2099-12-31T23:59':date('Y-m-dTH:i', strtotime($this->To));

		$this->Granularity = $this->input->get('Granularity'); // Granularity in minutes
	        $this->Granularity = is_integer($this->Granularity) ? $this->Granularity : 180; // in minutes

		$this->Station = end($this->station->config($station));
		// print_r($this->Station);
		$this->info = array("info"=>array(
			"lat"=>$this->Station['Geo:Latitude:NordValue'],
			"lon"=>$this->Station['Geo:Longitude:EstValue'],
			"alt"=>$this->Station['Geo:Elevation:Ocean'],
			"name"=>$this->Station['_name'],
			"id"=>$this->Station['_name']));

		if ($this->Since or $this->To or $this->Granularity) {
			$this->dataReader = new dao_data($this->Station, $this->sensor);
			// $this->load->model('dao/dao_data', 'dataReader'); // return $this->dataReader object
		}
		else {
			$this->dataReader = new dao_data_summary($this->Station);
			// $this->load->model('dao/dao_data_summary', 'dataReader'); // return $this->dataReader object
		}
	}



	function setSensor($str) {
		$this->sensor =  rawurldecode($str);
		// if (isset($this->sensors[16])) unset($this->sensors[16]);
		return $this->sensor;
	}


/**

* @
* @param 
* @param 
*/
	function index() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

	}

/**

* @
* @param since is the start date of result needed
* @param lenght is the number of day
* @param is the sensor name (one or more)
*/
	function curve($force=false){
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__);

		if (!$force) {
			// list($first,$last,$count);
			list($first,$last,$count) = array_values($this->dataReader->estimate (
				$this->Since,
				$this->To
			));

			if ((strtotime($last)-strtotime($first)) > $this->Granularity*2000) {
					;
				}
		}

		$data = $this->dataReader->curve (
			$this->Since,
			$this->To,
			$this->Granularity
		);
		$j = count($data);
	    $tsv = '';
	    for ($i=0;$i<$j;$i++) {
			$tsv .= substr(	$data[$i]['UTC_grp'],0,-3)."\t".
							$data[$i]['value']."\n";
		}

		$this->dl_tsv ("date\tval\n".trim($tsv,"\n"));
        $this->dl_tsv ($data);

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
	function bracketCurve($force=false){
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__);

		$data = $this->dataReader->bracketCurve (
			$this->Since,
			$this->To,
			$this->Granularity
		);

		$j = count($data);
	    $tsv = '';
	    for ($i=0;$i<$j;$i++) {
			$tsv .= substr(	$data[$i]['UTC_grp'],0,-3)."\t".
							$data[$i]['first']."\t".
							$data[$i]['min']."\t".
							$data[$i]['val']."\t".
							$data[$i]['max']."\t".
							$data[$i]['last']."\n";
		}

		$this->dl_tsv ("date\tfirst\tmin\tavg\tmax\tlast\n".trim($tsv,"\n"));
	}
/**
http://probe.dev/draw/windrose?station=VP2_GTD&sensors=TA:Arch:Temp:Out:Average&Since=2012-10-26T00:00:00&StepUnit=DAY&StepNbr=6
* @
* @param since is the start date of result needed
* @param lenght is the number of day
*/
	function wind(){
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$data = $this->dataReader->wind (
			$this->Since,
			$this->To,
			$this->Granularity
		);
		$this->dl_json ($data);
	}








	private function dl_json ($data) {
		$json = json_encode(array_merge($this->info, array('data' => $data)), JSON_NUMERIC_CHECK);
		// ob_clean();
		@ob_end_clean();
		header_remove();
		force_download('data.json', $json);
	}

	private function dl_tsv ($data) {
		// ob_clean();
		@ob_end_clean();
		header_remove();
		force_download('data.tsv', $data);
	}
}