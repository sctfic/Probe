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
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
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
}/*
[{"Step":"26","Direction":"NULL","NbSample":"12","SpeedAvg":"0 "	},
{"Step":"26","Direction":"45.0","NbSample":"30","SpeedAvg":"1.1"},
{"Step":"26","Direction":"67.5","NbSample":"70","SpeedAvg":"1.3285714285714285"},
{"Step":"26","Direction":"90.0","NbSample":"34","SpeedAvg":"1.2058823529411764"},
{"Step":"26","Direction":"112.5","NbSample":"7","SpeedAvg":"0.5714285714285714"},
{"Step":"26","Direction":"135.0","NbSample":"6","SpeedAvg":"0"},
{"Step":"26","Direction":"157.5","NbSample":"4","SpeedAvg":"0.5"},
{"Step":"26","Direction":"180.0","NbSample":"20","SpeedAvg":"0.7"},
{"Step":"26","Direction":"202.5","NbSample":"21","SpeedAvg":"0.47619047619047616"},
{"Step":"26","Direction":"225.0","NbSample":"19","SpeedAvg":"0.631578947368421"},
{"Step":"26","Direction":"247.5","NbSample":"4","SpeedAvg":"1"},
{"Step":"26","Direction":"270.0","NbSample":"22","SpeedAvg":"1.0454545454545454"},
{"Step":"26","Direction":"292.5","NbSample":"15","SpeedAvg":"3.2666666666666666"},
{"Step":"26","Direction":"315.0","NbSample":"22","SpeedAvg":"6.7272727272727275"},
{"Step":"26","Direction":"337.5","NbSample":"1","SpeedAvg":"7"},

{"Step":"27","Direction":"292.5","NbSample":"17","SpeedAvg":"7"},
{"Step":"27","Direction":"315.0","NbSample":"164","SpeedAvg":"8.329268292682928"},
{"Step":"27","Direction":"337.5","NbSample":"107","SpeedAvg":"10.981308411214954"},

{"Step":"28","Direction":"292.5","NbSample":"31","SpeedAvg":"6.870967741935484"},
{"Step":"28","Direction":"315.0","NbSample":"137","SpeedAvg":"7.737226277372263"},
{"Step":"28","Direction":"337.5","NbSample":"35","SpeedAvg":"8.542857142857143"},

{"Step":"29","Direction":"NULL","NbSample":"97","SpeedAvg":"0"},
{"Step":"29","Direction":"0.0","NbSample":"1","SpeedAvg":"4"},
{"Step":"29","Direction":"45.0","NbSample":"2","SpeedAvg":"3.5"},
{"Step":"29","Direction":"67.5","NbSample":"9","SpeedAvg":"2.2222222222222223"},
{"Step":"29","Direction":"90.0","NbSample":"60","SpeedAvg":"1.6666666666666667"},
{"Step":"29","Direction":"112.5","NbSample":"61","SpeedAvg":"1.2950819672131149"},
{"Step":"29","Direction":"135.0","NbSample":"16","SpeedAvg":"3.125"},
{"Step":"29","Direction":"157.5","NbSample":"6","SpeedAvg":"2.5"},
{"Step":"29","Direction":"180.0","NbSample":"2","SpeedAvg":"1.5"},
{"Step":"29","Direction":"247.5","NbSample":"15","SpeedAvg":"0.3333333333333333"},
{"Step":"29","Direction":"292.5","NbSample":"1","SpeedAvg":"2"},
{"Step":"29","Direction":"315.0","NbSample":"3","SpeedAvg":"0.3333333333333333"},

{"Step":"30","Direction":"NULL","NbSample":"45","SpeedAvg":"0"},
{"Step":"30","Direction":"22.5","NbSample":"4","SpeedAvg":"2"},
{"Step":"30","Direction":"45.0","NbSample":"43","SpeedAvg":"1.1395348837209303"},
{"Step":"30","Direction":"67.5","NbSample":"31","SpeedAvg":"2.3870967741935485"},
{"Step":"30","Direction":"90.0","NbSample":"45","SpeedAvg":"1.6666666666666667"},
{"Step":"30","Direction":"112.5","NbSample":"82","SpeedAvg":"1.4390243902439024"},
{"Step":"30","Direction":"135.0","NbSample":"24","SpeedAvg":"4.083333333333333"},
{"Step":"30","Direction":"157.5","NbSample":"11","SpeedAvg":"3"},
{"Step":"30","Direction":"337.5","NbSample":"3","SpeedAvg":"0.6666666666666666"},

{"Step":"31","Direction":"NULL","NbSample":"32","SpeedAvg":"0"},
{"Step":"31","Direction":"0.0","NbSample":"1","SpeedAvg":"0"},
{"Step":"31","Direction":"22.5","NbSample":"1","SpeedAvg":"1"},
{"Step":"31","Direction":"45.0","NbSample":"50","SpeedAvg":"0.8"},
{"Step":"31","Direction":"67.5","NbSample":"4","SpeedAvg":"1"},
{"Step":"31","Direction":"90.0","NbSample":"26","SpeedAvg":"0.38461538461538464"},
{"Step":"31","Direction":"112.5","NbSample":"1","SpeedAvg":"1"},
{"Step":"31","Direction":"135.0","NbSample":"59","SpeedAvg":"2.0677966101694913"},
{"Step":"31","Direction":"157.5","NbSample":"37","SpeedAvg":"2.108108108108108"},
{"Step":"31","Direction":"180.0","NbSample":"9","SpeedAvg":"1.2222222222222223"},
{"Step":"31","Direction":"202.5","NbSample":"4","SpeedAvg":"1.25"},
{"Step":"31","Direction":"225.0","NbSample":"8","SpeedAvg":"0.875"},
{"Step":"31","Direction":"247.5","NbSample":"8","SpeedAvg":"1.25"},
{"Step":"31","Direction":"270.0","NbSample":"27","SpeedAvg":"1.1481481481481481"},
{"Step":"31","Direction":"292.5","NbSample":"9","SpeedAvg":"1.3333333333333333"},
{"Step":"31","Direction":"315.0","NbSample":"12","SpeedAvg":"0.25"}]*/