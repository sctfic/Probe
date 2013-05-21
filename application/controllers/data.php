<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Data extends CI_Controller {
/**
	Cette classe appelle les differentes requetes
	en vu de les retourner au scripte ajax qui les dessinera
	*/

	protected $Station=NULL; // name or ID nbr of station
	protected $sensor=NULL; // name or ID nbr of station
	protected $Since=NULL; // start date of data
	protected $To=NULL;
	protected $Granularity=NULL;
	public $dataReader=NULL;
	protected $force=NULL;

/**

	* @
	* @param 
	* @param 
	*/
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
	        $this->Since = empty($this->Since) ? '2013-01-01T00:00':date('c', strtotime($this->Since));

		$this->To = $this->input->get('To');
	        $this->To = empty($this->To) ? '2099-12-31T23:59':date('c', strtotime($this->To));

		$this->force = $this->input->get('Force');
	        $this->force = empty($this->force) ? false : true;

		$this->Granularity = $this->input->get('Granularity'); // Granularity in minutes
			$this->Granularity = is_integer($this->Granularity*1) ? $this->Granularity : 0; // in minutes

		$this->displaySize = $this->input->get('displaySize'); // displaySize in pixels
			$this->displaySize = is_integer($this->displaySize*1) ? $this->displaySize : 0; // in pixels

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


/**

	* @
	* @param 
	* @param 
	*/
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
	* @param 
	* @param 
	*/
	function currents() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		
		$itemConf = end($this->station->config($this->Station['_name'])); // $station est le ID ou le nom
		$currents = $this->rebuild ($this->station->CurrentsCollector ($itemConf), 'Current');

//		echo uksort($currents['Current'], "strnatcasecmp");
		deep_ksort($currents);

		$this->dl_json ($currents);
	}



/**
make and download json curve of a sensor
	* @
	* @param since is the start date of result needed
	* @param lenght is the number of day
	* @param is the sensor name (one or more)
	*/
	function curve(){
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->Station['_name'], $this->Since,	$this->To,	$this->Granularity));

		if (!$this->force) {
			$recomandGranularity = $this->dataReader->estimate (
                $this->Since,
                $this->To,
                2000
            );
			if ($this->Granularity >= $recomandGranularity*4 || $this->Granularity <= $recomandGranularity/2 )
				$this->Granularity = $recomandGranularity;
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
make and download json bracketCurve of a sensor
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
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->Station['_name'], $this->Since,	$this->To,	$this->Granularity));

		$data = $this->dataReader->bracketCurve (
			$this->Since,
			$this->To,
			$this->Granularity
		);

		$j = count($data);
	    $tsv = '';
	    for ($i=0;$i<$j;$i++) {
			$tsv .= substr(	$data[$i]['UTC_grp'],0,-3)."\t".
							$data[$i]['min']."\t".
							$data[$i]['first']."\t".
							$data[$i]['val']."\t".
							$data[$i]['last']."\t".
							$data[$i]['max']."\n";
		}

		$this->dl_tsv ("date\tmin\tfirst\tavg\tlast\tmax\n".trim($tsv,"\n"));
	}
/**
make and download json wind data
	* @
	* @param since is the start date of result needed
	* @param lenght is the number of day
	*/
	function windRose(){
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->Station['_name'], $this->Since,	$this->To,	$this->Granularity));

		$this->Granularity = empty($this->Granularity) ? 360 : $this->Granularity ; // in minutes
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->Station['_name'], $this->Since,	$this->To,	$this->Granularity));

		$data = $this->dataReader->wind (
			$this->Since,
			$this->To,
			$this->Granularity
		);
		$this->dl_json ($data);
	}
/**
make and download json wind data
	* @
	* @param since is the start date of result needed
	* @param lenght is the number of day
	*/
	function histoWind(){
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->Station['_name'], $this->Since,	$this->To,	$this->Granularity));

		$this->Granularity = empty($this->Granularity) ? 360 : $this->Granularity ; // in minutes
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->Station['_name'], $this->Since,	$this->To,	$this->Granularity));

		$data = $this->dataReader->histoWind (
			$this->Since,
			$this->To,
			$this->Granularity
		);
		$j = count($data);
	    $tsv = '';
	    for ($i=0;$i<$j;$i++) {
			$tsv .= substr(	$data[$i]['UTC_grp'],0,-3)."\t".
							$data[$i]['AvgSpeed']."\t".
							$data[$i]['AvgDirection']."\t".
							$data[$i]['x']."\t".
							$data[$i]['y']."\n";
		}

		$this->dl_tsv ("date\tspeed\tangle\tx\ty\n".trim($tsv,"\n"));
	}

/**
rebuild array
	* @
	* @param data structure array()
	*/
	private function rebuild ($data, $mask) {
		$new = array();

		// on itaire sur tous les elements
		foreach ($data as $key => $value) {

			// recursif pour les array()
			if (is_array($value))
				$new = $this->rebuild($value, $mask);
			else {
				$keys = explode(':', $key);
				// seulement pour les enregistrement de type $mask == 'Current'
				if (empty($mask) || $keys[1]==$mask) {
					$n = &$new;

					// on ignore le premier segment
					for ($i=1; $i<count($keys); $i++)
					{
						// echo $keys[$i]." ";
						$n = &$n[$keys[$i]];
					}					
						// echo "\n";
					$n = $value;
				}
			}
		}
		return $new;
	}

/**
Download after convert data structure to json object
	* @
	* @param data structure array()
	*/
	private function dl_json ($data) {
		$json = json_encode(array_merge($this->info, array('data' => $data)), JSON_NUMERIC_CHECK);
		// ob_clean();
		@ob_end_clean();
		header_remove();
		force_download('data.json', $json);
	}

/**
Download tsv file
	* @
	* @param data structure array()
	*/
	private function dl_tsv ($data) {
		// ob_clean();
		@ob_end_clean();
		header_remove();
		force_download('data.tsv', $data);
	}
}