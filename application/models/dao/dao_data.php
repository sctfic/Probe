<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dao_data extends CI_Model {
/**
Cette classe appelle les differentes requetes
en vu de les retourner au scripte ajax qui les dessinera
*/
    protected $dataDB = NULL;
    public $SEN_LST = array();
    function __construct($station) {
        parent::__construct();
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
        $this->dataDB = $this->load->database($station, TRUE);
        $this->SEN_LST = $this->sensor_list();
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
* @param 
* @param 
*/
    function sensor_list(){
        $query = "SELECT `SEN_ID` AS  `value`, `SEN_NAME` AS `key` FROM `TR_SENSOR` LIMIT 0 , 100";
        $qurey_result = $this->dataDB->query($query);
        $brut = $qurey_result->result_array($qurey_result);
        $reformated = null;
        foreach ($brut as $Sensor) {
            $reformated [$Sensor['key']] = $Sensor['value'];
        }
        return $reformated;
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
*        for each we return by period :
*           [first period value,
*           min period value,
*           avg period value,
*           max period value,
*           last period value]
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
* @
* @param since is the start date of result needed
* @param lenght is the number of day
*/
    function wind($since='2012-01-01', $step='DAY', $lenght=365){
        $STEP = array('HOUR'=>'HOUR', 'DAY'=>'DAY', 'WEEK'=>'WEEK', 'MONTH'=>'MONTH');
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
        try {
        $queryString = sprintf(file_get_contents(APPPATH.'models/sql/wind.sql'),
            $this->SEN_LST['TA:Arch:Various:Wind:DominantDirection'],
            $this->SEN_LST['TA:Arch:Various:Wind:HighSpeed'],
            $this->SEN_LST['TA:Arch:Various:Wind:HighSpeedDirection'],
            $this->dataDB->escape($since),
            $this->dataDB->escape($since),
            $this->dataDB->escape($lenth),
            $STEP[$step],
            $this->SEN_LST['TA:Arch:Various:Wind:SpeedAvg'],
            $this->dataDB->escape($since),
            $this->dataDB->escape($since),
            $this->dataDB->escape($lenth),
            $STEP[$step]
        );
/**
    -- 9 SpeedAvg             =   sur la periode de la station (5min)
    -- 12 Dominant            =   Direction pour SpeedAvg
    -- 10 HighSpeed           =   rafalle maxi mesurée sur la periode
    -- 11 HighSpeedDirection  =   direction de la rafalle, n'est pas la direction dominante
*/
            $qurey_result = $this->dataDB->query($queryString);// ,
            //     array(
            //         ':since' => $this->dataDB->escape($since),
            //         ':lenght' => $this->dataDB->escape($lenth),
            //         ':step' => $STEP[$step],
            //         ':AvgS' => $this->SEN_LST['TA:Arch:Various:Wind:SpeedAvg'],
            //         ':MaxS' => $this->SEN_LST['TA:Arch:Various:Wind:HighSpeed'],
            //         ':AvgD' => $this->SEN_LST['TA:Arch:Various:Wind:DominantDirection'],
            //         ':MaxD' => $this->SEN_LST['TA:Arch:Various:Wind:HighSpeedDirection']
            //     ));
            // print_r($qurey_result);
            $brut = $qurey_result->result_array($qurey_result);
            $reformated = null;
            foreach ($brut as $key => $value) {
                if (isset($reformated[$value['_Day']]))
                    $reformated[$value['_Day']] = array_merge(
                        $reformated[$value['_Day']],
                        array(array('Dir'=>$value['DominantDirection'], 'Spd'=>$value['SpeedAverage'], 'Spl'=>$value['SampleCount'], 'Max'=>$value['DayMaxSpeedInThisDirection']))
                    );
                else
                    $reformated[$value['_Day']] = array(array('Dir'=>$value['DominantDirection'], 'Spd'=>$value['SpeedAverage'], 'Spl'=>$value['SampleCount'], 'Max'=>$value['DayMaxSpeedInThisDirection']));
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