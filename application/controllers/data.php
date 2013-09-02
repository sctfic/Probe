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
	protected $XdisplaySizePxl=NULL;
	protected $infos=FALSE;
	public $dataReader=NULL;

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
		// include_once(APPPATH.'models/dao/dao_data_summary.php');

		$this->load->helper('download');

		$this->station = new Station();
		// encoded with javascript encodeURIComponent()
		$station = rawurldecode($this->input->get('station'));

		$this->setSensor($this->input->get('sensor'));

		$this->Since = rawurldecode($this->input->get('Since'));
	        $this->Since = empty($this->Since) ? '2013-01-01T00:00':date('c', strtotime($this->Since));

		$this->To = $this->input->get('To');
	        $this->To = empty($this->To) ? '2037-12-31T23:59':date('c', strtotime($this->To));

		$this->infos = $this->input->get('infos');
	        $this->infos = empty($this->infos) ? FALSE:TRUE;

		$this->XdisplaySizePxl = $this->input->get('XdisplaySizePxl'); // XdisplaySizePxl in pixels
			$this->XdisplaySizePxl = 
				(is_integer($this->XdisplaySizePxl*1)) ? $this->XdisplaySizePxl : 640; // in pixels

		$this->Station = end($this->station->config($station));
		// where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->SEN_DTL,$RAIN_COLLECTOR));
		$this->dataReader = new dao_data($this->Station, $this->sensor);
	    $RAIN_COLLECTOR = array(0=>0.01, 1=>0.2, 2=>0.1); 
		$this->info = array("ISS"=>array(
			"lat" => $this->Station['Geo:Latitude:NordValue'],
			"lon" => $this->Station['Geo:Longitude:EstValue'],
			"alt" => $this->Station['Geo:Elevation:Ocean'],
			"name" => $this->Station['_name'],
			"id" => $this->Station['_id'],
			"wCup" => $this->Station['Wind:Cup:Large'],
			"rConv" => $RAIN_COLLECTOR [$this->Station['Rain:Collector:Size']] ),
		"sensor" => $this->dataReader->SEN_DTL);
	}


/**

	* @
	* @param 
	* @param 
	*/
	function setSensor($str) {
		$this->sensor = empty($str) ? 'TA:Arch:Temp:Out:Average' : rawurldecode($str);
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
return an Json Obj of all currents value LOOP, LOOP2, HILOW
	* @
	* @param 
	* @param 
	*/
	function currents() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		
		if (!$this->infos) {
			$itemConf = end($this->station->config($this->Station['_name'])); // $station est le ID ou le nom
			$currents = $this->rebuild ($this->station->CurrentsCollector ($itemConf), 'Current');

			// echo uksort($currents['Current'], "strnatcasecmp");
			deep_ksort($currents);

			$this->dl_json ($currents);
		}
		else $this->dl_dataHeader($dataHeader);
	}



/**
make and download tsv curve of a sensor
	* @
	* @param since is the start date of result needed
	* @param lenght is the number of day
	* @param is the sensor name (one or more)
	*/
	function curve(){
		$dataHeader = $this->dataReader->estimate ( $this->Since, $this->To, $this->XdisplaySizePxl/2 );
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->Station['_name'], $this->Since,	$this->To,	$this->XdisplaySizePxl, $dataHeader));


		if (!$this->infos) {
			$data = $this->dataReader->curve ($this->Since, $this->To, $dataHeader['step'] );

			$j = count($data);
		    $tsv = '';
		    for ($i=0;$i<$j;$i++) {
				$tsv .= substr(	$data[$i]['UTC_grp'],0,-3)."\t".
								$data[$i]['value']."\n";
			}

			$this->dl_tsv ("date\tval\n".trim($tsv,"\n"));
	        $this->dl_tsv ($data);
		}
		else $this->dl_dataHeader($dataHeader);
	}

/**
make and download tsv sum value of a sensor
	* @
	* @param since is the start date of result needed
	* @param lenght is the number of day
	* @param is the sensor name (one or more)
	*/
	function cumul(){
		$dataHeader = $this->dataReader->estimate ( $this->Since, $this->To, $this->XdisplaySizePxl/12 );
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->Station['_name'], $this->Since,	$this->To,	$this->XdisplaySizePxl, $dataHeader));


		if (!$this->infos) {
			$data = $this->dataReader->cumul ($this->Since, $this->To, $dataHeader['step'] );

			$j = count($data);
		    $tsv = '';
		    for ($i=0;$i<$j;$i++) {
				$tsv .= substr(	$data[$i]['UTC_grp'],0,-3)."\t".
								$data[$i]['value']."\n";
			}

			$this->dl_tsv ("date\tval\n".trim($tsv,"\n"));
	        $this->dl_tsv ($data);
		}
		else $this->dl_dataHeader($dataHeader);
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
		$dataHeader = $this->dataReader->estimate ( $this->Since, $this->To, $this->XdisplaySizePxl/8 );
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->Station['_name'], $this->Since,	$this->To,	$this->XdisplaySizePxl, $dataHeader));


		if (!$this->infos) {
			$data = $this->dataReader->bracketCurve (	$this->Since,	$this->To,	$dataHeader['step'] );

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
		else $this->dl_dataHeader($dataHeader);
	}
/**
make and download json wind data
	* @
	* @param since is the start date of result needed
	* @param lenght is the number of day
	*/
	function windRose(){
		$dataHeader = $this->dataReader->estimate ( $this->Since, $this->To, $this->XdisplaySizePxl/12 );
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->Station['_name'], $this->Since,	$this->To,	$this->XdisplaySizePxl, $dataHeader));

		
		if (!$this->infos) {
			$data = $this->dataReader->wind (	$this->Since,	$this->To,	$dataHeader['step'] );

			$this->dl_json ($data);
		}
		else $this->dl_dataHeader($dataHeader);
	}
/**
make and download json wind data for vectorial HairChart
	* @
	* @param since is the start date of result needed
	* @param lenght is the number of day
	*/
	function histoWind(){
		$dataHeader = $this->dataReader->estimate ( $this->Since, $this->To, $this->XdisplaySizePxl/3 );
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->Station['_name'], $this->Since,	$this->To,	$this->XdisplaySizePxl, $dataHeader));

		if (!$this->infos) {
			$data = $this->dataReader->histoWind (	$this->Since,	$this->To,	$dataHeader['step']);
		
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
		else $this->dl_dataHeader($dataHeader);
	}

/**
rebuild array of EEPROM currents values to made an arborescence.
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
Download after convert data structure to json object
	* @
	* @param data structure array()
	*/
	private function dl_dataHeader ($dataHeader) {
		$json = json_encode(array_merge($this->info, $dataHeader), JSON_NUMERIC_CHECK);
		// ob_clean();
		@ob_end_clean();
		header_remove();
		force_download('data.json', $json);		}

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