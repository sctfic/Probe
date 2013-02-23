<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dao_data extends CI_Model {
/**
Cette classe appelle les differentes requetes
en vu de les retourner au scripte ajax qui les dessinera
*/
    protected $dataDB = NULL;
    public $SEN_LST = array();
    protected $STEP = array('HOUR'=>'HOUR', 'DAY'=>'DAY', 'WEEK'=>'WEEK', 'MONTH'=>'MONTH');
    function __construct($station, $sensor) {
        parent::__construct();
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__);
        $this->dataDB = $this->load->database($station, TRUE);
        $this->SEN_LST = $this->sensor_list();
        $this->SEN_ID = $this->SEN_LST[$sensor];
        $this->SEN_TABLE = tableOfSensor($sensor);
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

    function estimate($since='2013-01-01T00:00', $to='2099-12-31T23:59') {
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
        $queryString = 
        "SELECT MIN(  `UTC` ) AS first, MAX(  `UTC` ) AS last, COUNT(  `UTC` ) AS count
            FROM  `".$this->SEN_TABLE."` 
            WHERE SEN_ID = ".$this->SEN_ID."
                AND utc >= '$since'
                AND utc < '$to'";
        $qurey_result = $this->dataDB->query($queryString);
        $brut = $qurey_result->result_array($qurey_result);
        return end($brut);
    }
/**

* @
* @param since is the start date of result needed
* @param lenght is the number of day
* @param is the sensor name (one or more)
*/
    function curve($since='2013-01-01T00:00', $to='2099-12-31T23:59', $Granularity=180) {
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

        $queryString = 
        "SELECT FROM_UNIXTIME( TRUNCATE( UNIX_TIMESTAMP(`UTC`) / ".($Granularity*60).", 0)*".($Granularity*60)." ) as UTC_grp , round(avg(value), 2) as `value`
            FROM  `".$this->SEN_TABLE."` 
            WHERE SEN_ID = ".$this->SEN_ID."
                AND utc >= '$since'
                AND utc < '$to'
        GROUP BY UTC_grp
        ORDER BY UTC_grp asc
        LIMIT 0 , 5000";

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
    function bracketCurve($since='2013-01-01T00:00', $to='2099-12-31T23:59', $Granularity=180) {
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
        // Stock Price
        // Date,Open,High,Low,Close,Volume
        // [["2012-03-01",15.21,15.43,15.15,15.25,11248600],
        //  ["2012-02-29",15.38,15.64,15.14,15.15,17229900],
        //  ["2012-02-28",15.47,15.65,15.17,15.33,17497100],
        //  ["2012-02-27",15.59,15.66,15.25,15.47,18631700],
        //  ["2012-02-24",15.96,15.98,15.72,15.79,9166700],

        $queryString = 
        "SELECT FROM_UNIXTIME( TRUNCATE( UNIX_TIMESTAMP(`UTC`) / ".($Granularity*60).", 0)*".($Granularity*60)." ) as UTC_grp ,
                SUBSTRING_INDEX(GROUP_CONCAT(CAST(`value` AS CHAR) ORDER BY utc),',',1) as first,
                round(min(`value`), 2) as min,
                round(avg(`value`), 2) as val,
                round(max(`value`), 2) as max,
                SUBSTRING_INDEX(GROUP_CONCAT(CAST(`value` AS CHAR) ORDER BY utc),',',-1) as last
            FROM  `".$this->SEN_TABLE."` 
            WHERE SEN_ID = ".$this->SEN_ID."
                AND utc >= '$since'
                AND utc < '$to'
        GROUP BY UTC_grp
        ORDER BY UTC_grp asc
        LIMIT 0 , 1000";

        $qurey_result = $this->dataDB->query($queryString);// ,
        $brut = $qurey_result->result_array($qurey_result);
        return $brut;
    }

/**
* @
* @param since is the start date of result needed
* @param lenght is the number of day
*/
    function wind($since='2013-01-01', $to='2099-12-31T23:59', $Granularity=180){

        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
        try {
        $queryString = sprintf(file_get_contents(SQL_DIR.'wind.sql'),
            $Granularity*60,
            $Granularity*60,
            $this->SEN_LST['TA:Arch:Various:Wind:DominantDirection'],

            $this->SEN_LST['TA:Arch:Various:Wind:HighSpeed'],
            $this->SEN_LST['TA:Arch:Various:Wind:HighSpeedDirection'],
            $since,
            $to,
            $this->SEN_LST['TA:Arch:Various:Wind:SpeedAvg'],
            $since,
            $to
        );
        print_r($queryString);

            $qurey_result = $this->dataDB->query($queryString);// ,

            $brut = $qurey_result->result_array($qurey_result);
            $reformated = null;
            foreach ($brut as $key => $value) {
                if (isset($reformated[$value['UTC_grp']]))
                    $reformated[$value['UTC_grp']] = array_merge(
                        $reformated[$value['UTC_grp']],
                        array(array('Dir'=>$value['DominantDirection'], 'Spd'=>$value['SpeedAverage'], 'Spl'=>$value['SampleCount'], 'Max'=>$value['UTC_grpMaxSpeedInThisDirection']))
                    );
                else
                    $reformated[$value['UTC_grp']] = array(array('Dir'=>$value['DominantDirection'], 'Spd'=>$value['SpeedAverage'], 'Spl'=>$value['SampleCount'], 'Max'=>$value['UTC_grpMaxSpeedInThisDirection']));
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