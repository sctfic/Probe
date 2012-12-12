<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dao_data extends CI_Model {
/**
Cette classe appelle les differentes requetes
en vu de les retourner au scripte ajax qui les dessinera
*/
	protected $dataDB = NULL;

	function __construct($station) {
		parent::__construct();
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$this->dataDB = $this->load->database($station, TRUE);
	}

/**

* @
* @param 
* @param 
*/
	function index(){

	}

/**

* @
* @param since is the start date of result needed
* @param lenght is the number of day
* @param is the sensor name (one or more)
*/
	function curves($since, $lenght){
		
		$args = func_get_args();
	    foreach ($args as $value) {
	     	
	    }
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
	function bracketCurve($since, $lenght){
		
		$args = func_get_args();
	    foreach ($args as $value) {
	     	
	    }
	}

/**

* @
* @param since is the start date of result needed
* @param lenght is the number of day
*/
	function windrose($since='2012-01-01', $step='MONTH', $lenght=12){
		try {
			$query = "SELECT ".$step."(  `VAR_DATE` ) as Step, IFNULL(  `VAR_WIND_SPEED_DOMINANT_DIR` * 22.5,  'null' ) AS Direction, COUNT( * ) AS NbSample, AVG(  `VAR_WIND_SPEED` ) AS SpeedAvg
				FROM  `TA_VARIOUS` 
				WHERE `VAR_DATE` > '".$since."' and `VAR_DATE`< date_add('".$since."' ,  INTERVAL ".$lenght." ".$step.")
				GROUP BY ".$step."(  `VAR_DATE` ) ,  `VAR_WIND_SPEED_DOMINANT_DIR` 
				LIMIT 0 , 300";
			// $query = "SELECT CONCAT_WS(  ':', ".$step."(  `VAR_DATE` ) , IFNULL(  `VAR_WIND_SPEED_DOMINANT_DIR` * 22.5,  'NULL' ) ) AS Direction, COUNT( * ) AS NbSample, AVG(  `VAR_WIND_SPEED` ) AS SpeedAvg
			// 	FROM  `TA_VARIOUS` 
			// 	WHERE `VAR_DATE` > '".$since."' and `VAR_DATE`< date_add('".$since."' ,  INTERVAL ".$lenght." ".$step.")
			// 	GROUP BY ".$step."(  `VAR_DATE` ) ,  `VAR_WIND_SPEED_DOMINANT_DIR` 
			// 	LIMIT 0 , 300";
			$qurey_result = $this->dataDB->query($query);
			return $qurey_result->result_array($qurey_result);
		} catch (PDOException $e) {
			throw new Exception( $e->getMessage() );
		}

	}
/**

* @
* @param since is the start date of result needed
* @param lenght is the number of day
*/
	function windrose_allInOne($since, $lenght){

	}
}