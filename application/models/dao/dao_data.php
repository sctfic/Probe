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
		// Stock Price
// Date,Open,High,Low,Close,Volume
// [["2012-03-01",15.21,15.43,15.15,15.25,11248600],
//  ["2012-02-29",15.38,15.64,15.14,15.15,17229900],
//  ["2012-02-28",15.47,15.65,15.17,15.33,17497100],
//  ["2012-02-27",15.59,15.66,15.25,15.47,18631700],
//  ["2012-02-24",15.96,15.98,15.72,15.79,9166700],
		$args = func_get_args();
	    foreach ($args as $value) {
	     	
	    }
	}

/**
SELECT DATE(  `VAR_DATE` ) AS _date, IFNULL(  `VAR_WIND_SPEED_DOMINANT_DIR` * 22.5,  'null' ) AS _Dir, COUNT( * ) AS _Spl, ROUND( AVG(  `VAR_WIND_SPEED` ) , 3 ) AS _Spd, ROUND( MAX(  `VAR_WIND_SPEED` ) , 2 ) AS Max
FROM  `TA_VARIOUS` 
WHERE  `VAR_DATE` >  '2012-01-01T00:00:00'
AND  `VAR_DATE` < DATE_ADD(  '2012-01-01T00:00:00', INTERVAL 365 
DAY ) 
GROUP BY DATE(  `VAR_DATE` ) ,  `VAR_WIND_SPEED_DOMINANT_DIR` 
ORDER BY DATE(  `VAR_DATE` ) 
* @
* @param since is the start date of result needed
* @param lenght is the number of day
*/
	function wind($since='2012-01-01', $step='DAY', $lenght=365){
		try {
	$query = 
"SELECT _Date AS _Date, SUM( NbEchantillon ) AS Spl, ROUND(AVG( vmoyenne ),3) AS Spd, MAX( vmax ) AS Max, IFNULL( Dir * 22.5,  'null' ) AS Dir
FROM (
	SELECT DATE(  `VAR_DATE` ) AS _Date, COUNT( * ) AS NbEchantillon, AVG( VAR_WIND_SPEED ) AS vmoyenne, 0 AS vmax,  `VAR_WIND_SPEED_DOMINANT_DIR` AS Dir
	FROM  `TA_VARIOUS` 
	WHERE  `VAR_DATE` > '$since' AND `VAR_DATE` < DATE_ADD( '$since', INTERVAL $lenght $step )
	GROUP BY DATE(  `VAR_DATE` ) ,  `VAR_WIND_SPEED_DOMINANT_DIR` 
	LIMIT 0 , 2000
UNION ALL 
	SELECT DATE(  `VAR_DATE` ) AS _Date, 0 AS NbEchantillon, 0 AS vmoyenne, MAX( VAR_WIND_SPEED_HIGHT ) AS vmax,  `VAR_WIND_SPEED_HIGHT_DIR` AS Dir
	FROM  `TA_VARIOUS` 
	WHERE  `VAR_DATE` > '$since' AND `VAR_DATE` < DATE_ADD( '$since', INTERVAL $lenght $step )
	GROUP BY DATE(  `VAR_DATE` ) ,  `VAR_WIND_SPEED_DOMINANT_DIR` 
	LIMIT 0 , 2000
) AS _Union
GROUP BY _Date, Dir
ORDER BY _Date
LIMIT 0 , 2000";

// 	$query =
// "SELECT 
// 	DATE( `VAR_DATE` ) AS _Date, 
// 	IFNULL( `VAR_WIND_SPEED_DOMINANT_DIR` * 22.5, 'null' ) AS Dir, 
// 	COUNT( * ) AS Spl,
// 	ROUND( AVG( `VAR_WIND_SPEED` ) , 3 ) AS Spd,
// 	ROUND( MAX( `VAR_WIND_SPEED_HIGHT` ) , 2 ) AS Max
// FROM  `TA_VARIOUS` 
// WHERE  `VAR_DATE` > '$since'
// AND  `VAR_DATE` < DATE_ADD( '$since', INTERVAL $lenght $step ) 
// GROUP BY DATE( `VAR_DATE` ) , `VAR_WIND_SPEED_DOMINANT_DIR` 
// ORDER BY DATE( `VAR_DATE` )
// LIMIT 0 , 1000";

			$qurey_result = $this->dataDB->query($query);
			$brut = $qurey_result->result_array($qurey_result);
			$reformated = null;
			foreach ($brut as $key => $value) {
				if (isset($reformated[$value['_Date']]))
					$reformated[$value['_Date']] = array_merge(
						$reformated[$value['_Date']],
						array(array('Dir'=>$value['Dir'], 'Spd'=>$value['Spd'], 'Spl'=>$value['Spl'], 'Max'=>$value['Max']))
					);
				else
					$reformated[$value['_Date']] = array(array('Dir'=>$value['Dir'], 'Spd'=>$value['Spd'], 'Spl'=>$value['Spl'], 'Max'=>$value['Max']));
			}
			return $reformated;
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