<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dao_data extends CI_Model {
/**
Cette classe appelle les differentes requetes
en vu de les retourner au scripte ajax qui les dessinera
*/
    protected $dataDB = NULL;
    public $SEN_LST = array();
    protected $STEP = array('HOUR'=>'HOUR', 'DAY'=>'DAY', 'WEEK'=>'WEEK', 'MONTH'=>'MONTH');
    function __construct($station) {
        parent::__construct();
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__);
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
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
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
    function curve($table, $sensor, $since='2013-01-01', $step='DAY', $length=365) {
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
        $since = $this->dataDB->escape($since);
        $SEN_ID = $this->SEN_LST[$sensor];
        $step = $this->STEP[$step];
        $length = is_integer($length) ? $length : 365;

        $queryString = 
        "SELECT utc, value 
            FROM  `$table` 
            WHERE SEN_ID = $SEN_ID 
                AND utc >=$since 
                AND utc < DATE_ADD($since, INTERVAL $length $step)
        LIMIT 0 , 10000";
        $qurey_result = $this->dataDB->query($queryString);// ,

        $brut = $qurey_result->result_array($qurey_result);
        return $brut;
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
    function bracketCurve($since, $lenght) {
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
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
* @
* @param since is the start date of result needed
* @param lenght is the number of day
*/
    function wind($since='2013-01-01', $step='DAY', $length=365){
        $since = $this->dataDB->escape($since);
        $length = is_integer($length)?$length:365;
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
        try {
        $queryString = sprintf(file_get_contents(APPPATH.'models/sql/wind.sql'),
            $this->SEN_LST['TA:Arch:Various:Wind:DominantDirection'],
            $this->SEN_LST['TA:Arch:Various:Wind:HighSpeed'],
            $this->SEN_LST['TA:Arch:Various:Wind:HighSpeedDirection'],
            $since,
            $since,
            $length,
            $this->STEP[$step],
            $this->SEN_LST['TA:Arch:Various:Wind:SpeedAvg'],
            $since,
            $since,
            $length,
            $this->STEP[$step]
        );
            $qurey_result = $this->dataDB->query($queryString);// ,

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
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

    }
}