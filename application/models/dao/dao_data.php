<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dao_data extends CI_Model {
/**
    Cette classe appelle les differentes requetes
    en vu de les retourner au script ajax qui les dessinera
    */
    protected $dataDB = NULL;
    public $SEN_LST = array();
    protected $STEP = array('HOUR'=>'HOUR', 'DAY'=>'DAY', 'WEEK'=>'WEEK', 'MONTH'=>'MONTH');
    function __construct($station, $sensor) {
        parent::__construct();
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__);
        $this->dataDB = $this->load->database($station, TRUE);
        $this->SEN_LST = $this->sensor_list();
        if (!empty($sensor)) {
            $this->SEN_ID = $this->SEN_LST[$sensor];
            $this->SEN_TABLE = tableOfSensor($sensor);
        }
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

    * @ this functione estimate the recommanded granularity between 2 date for retunr 1000 value
    * @param $since is the start date of result needed
    * @param $to is the end date of result needed
    */
    function estimate($since='2013-01-01T00:00', $to='2099-12-31T23:59', $nbr = 1000) {
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
        $queryString = 
        "SELECT MIN(  `UTC` ) AS first, MAX(  `UTC` ) AS last, COUNT(  `UTC` ) AS count
            FROM  `".$this->SEN_TABLE."` 
            WHERE SEN_ID = ".$this->SEN_ID."
                AND utc >= '$since'
                AND utc < '$to'";

        $qurey_result = $this->dataDB->query($queryString);
        list($first,$last,$count) = array_values( end($qurey_result->result_array($qurey_result)) );

        $GranularityForNbrValue = round((strtotime($last)-strtotime($first)) / $count * ($count/$nbr) / 60 , 1);

        return $GranularityForNbrValue<5 ? 5 : $GranularityForNbrValue;
    }


/**

    * @
    * @param $since is the start date of result needed
    * @param $to is the end date of result needed
    * @param $Granularity
    */
    function curve($since='2013-01-01T00:00', $to='2099-12-31T23:59', $Granularity=180) {
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

        $queryString = 
        "SELECT FROM_UNIXTIME( TRUNCATE( UNIX_TIMESTAMP(`UTC`) / ".($Granularity*60).", 0)*".($Granularity*60)."+".($Granularity*60/2)." ) as UTC_grp , round(avg(value), 2) as `value`
            FROM  `".$this->SEN_TABLE."` 
            WHERE SEN_ID = ".$this->SEN_ID."
                AND utc >= '$since'
                AND utc < '$to'
        GROUP BY UTC_grp
        ORDER BY UTC_grp asc
        LIMIT 0 , 100000";

        $qurey_result = $this->dataDB->query($queryString);

        $brut = $qurey_result->result_array($qurey_result);
        return $brut;
    }


/**

    * @
    * @param $since is the start date of result needed
    * @param $to is the end date of result needed
    * @param $Granularity
    * @param is the sensor name (one or more)
    *
    * @return for each we return by period :
    *           [first period value,
    *           min period value,
    *           avg period value,
    *           max period value,
    *           last period value]
    */
    function bracketCurve($since='2013-01-01T00:00', $to='2099-12-31T23:59', $Granularity=180) {
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

        $queryString = 
        "SELECT FROM_UNIXTIME( TRUNCATE( UNIX_TIMESTAMP(`UTC`) / ".($Granularity*60).", 0)*".($Granularity*60)."+".($Granularity*60/2)." ) as UTC_grp ,
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
        LIMIT 0 , 10000";

        $qurey_result = $this->dataDB->query($queryString);
        $brut = $qurey_result->result_array($qurey_result);
        return $brut;
    }

/**
requete pour la rose des vent
    * @
    * @param $since is the start date of result needed
    * @param $to is the end date of result needed
    * @param $Granularity
    *
    * @return 
    * 
    */
    function wind($since='2013-01-01T00:00', $to='2099-12-31T23:59', $Granularity=360){

        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
        try {
        $queryString = sprintf(file_get_contents(SQL_DIR.'wind.sql'),
            $Granularity*60,
            $Granularity*60,
            $Granularity*60/2,
            $this->SEN_LST['TA:Arch:Various:Wind:DominantDirection'],
            $this->SEN_LST['TA:Arch:Various:Wind:HighSpeed'],
            $this->SEN_LST['TA:Arch:Various:Wind:HighSpeedDirection'],
            $since,
            $to,
            $this->SEN_LST['TA:Arch:Various:Wind:SpeedAvg'],
            $since,
            $to
        );

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
requete pour le l'histogramme des vents
    * @
    * @param $since is the start date of result needed
    * @param $to is the end date of result needed
    * @param $Granularity
    *
    * @return 
    * 
    */
    function histoWind($since='2013-01-01T00:00', $to='2099-12-31T23:59', $Granularity=360){

        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

        $queryString = sprintf(file_get_contents(SQL_DIR.'histoWind.sql'),
            $Granularity*60,
            $Granularity*60,
            $Granularity*60/2,
            $this->SEN_LST['TA:Arch:Various:Wind:DominantDirection'],
            $this->SEN_LST['TA:Arch:Various:Wind:SpeedAvg'],
            $since,
            $to
        );
        $qurey_result = $this->dataDB->query($queryString);
        $brut = $qurey_result->result_array($qurey_result);
        return $brut;
    }

/**

    * @
    * @param $since is the start date of result needed
    * @param $to is the end date of result needed
    * @param $Granularity
    *
    * @return 
    * 
    */
    function windrose_allInOne($since='2013-01-01', $to='2099-12-31T23:59', $Granularity=180){
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

    }
}