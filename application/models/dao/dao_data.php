<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dao_data extends CI_Model {
/**
    Cette classe appelle les differentes requetes
    en vu de les retourner au script ajax qui les dessinera
    */
    protected $dataDB = NULL;
    public $SEN_LST = array();
    public $SEN_DTL = array();
    protected $STEP = array('HOUR'=>'HOUR', 'DAY'=>'DAY', 'WEEK'=>'WEEK', 'MONTH'=>'MONTH');
    function __construct($station, $sensor) {
        parent::__construct();
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__);
        $this->dataDB = $this->load->database($station, TRUE);
        $this->SEN_LST = $this->sensor_list();
        if (!empty($sensor)) {
            $this->SEN_ID = $this->SEN_LST[$sensor];
            $this->SEN_TABLE = tableOfSensor($sensor);
            $this->SEN_DTL = $this->sensor_detail($this->SEN_ID);
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
construit la liste des capteur et de leur ID
    * @
    * @param 
    * @param 
    */
    function sensor_list(){
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
        $query = "SELECT `SEN_ID` AS  `value`, `SEN_NAME` AS `key` FROM `TR_SENSOR` LIMIT 0 , 100";
        $query_result = $this->dataDB->query($query);
        $brut = $query_result->result_array($query_result);
        $reformated = null;
        foreach ($brut as $Sensor) {
            $reformated [$Sensor['key']] = $Sensor['value'];
        }
        return $reformated;
    }
/**
construit la liste des detail sur un capteur
    * @
    * @param 
    * @param 
    */
    function sensor_detail($SEN_ID){
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
        $query = "SELECT * FROM  `TR_SENSOR` WHERE  `SEN_ID` = $SEN_ID LIMIT 0 , 30";
        $query_result = $this->dataDB->query($query);
        $brut = $query_result->result_array($query_result);
        return end($brut);
    }


/**
this functione estimate the recommanded granularity between 2 date for retunr 1000 value
    * @
    * @param $since is the start date of result needed
    * @param $to is the end date of result needed
    */
    function estimate($since='2013-01-01T00:00', $to='2037-12-31T23:59', $nbr = 1000) {
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
        $queryString = 
        "SELECT MIN(`UTC`) AS first, MAX(`UTC`) AS last, COUNT(`UTC`) AS count, MIN(value) AS min, MAX(value) AS max, AVG(value) AS avg, SUM(value) AS sum
            FROM  `".$this->SEN_TABLE."` 
            WHERE SEN_ID = ".$this->SEN_ID."
                AND utc >= '$since'
                AND utc < '$to'";

        $query_result = $this->dataDB->query($queryString);

        list($first, $last, $count, $min, $max, $avg, $sum) = array_values( end($query_result->result_array($query_result)) );

        $GranularityForNbrValue = round((strtotime($last)-strtotime($first)) / $count * ($count/$nbr) / 60 , 1);

        return array ('step'=>$GranularityForNbrValue<5 ? 5 : $GranularityForNbrValue, 'count'=>$count, 'min'=>$min, 'max'=>$max, 'avg'=>$avg, 'sum'=>$sum);
    }


/**

    * @
    * @param $since is the start date of result needed
    * @param $to is the end date of result needed
    * @param $Granularity
    */
    function curve($since='2013-01-01T00:00', $to='2037-12-31T23:59', $Granularity=180) {
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

        $query_result = $this->dataDB->query($queryString);

        $brut = $query_result->result_array($query_result);
        return $brut;
    }

/**

    * @
    * @param $since is the start date of result needed
    * @param $to is the end date of result needed
    * @param $Granularity
    */
    function cumul($since='2013-01-01T00:00', $to='2037-12-31T23:59', $Granularity=180) {
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

        $queryString = 
        "SELECT FROM_UNIXTIME( TRUNCATE( UNIX_TIMESTAMP(`UTC`) / ".($Granularity*60).", 0)*".($Granularity*60)."+".($Granularity*60/2)." ) as UTC_grp , round(sum(value),3) as `value`
            FROM  `".$this->SEN_TABLE."` 
            WHERE SEN_ID = ".$this->SEN_ID."
                AND utc >= '$since'
                AND utc < '$to'
        GROUP BY UTC_grp
        ORDER BY UTC_grp asc
        LIMIT 0 , 100000";

        $query_result = $this->dataDB->query($queryString);

        $brut = $query_result->result_array($query_result);
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
    function bracketCurve($since='2013-01-01T00:00', $to='2037-12-31T23:59', $Granularity=180) {
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

        $queryString = 
        "SELECT FROM_UNIXTIME( TRUNCATE( UNIX_TIMESTAMP(`UTC`) / ".($Granularity*60).", 0)*".($Granularity*60)."+".($Granularity*60/2)." ) as UTC_grp ,
                -- SUBSTRING_INDEX(GROUP_CONCAT(CAST(`value` AS CHAR) ORDER BY utc),',',1) as first,
                round(min(`value`), 2) as min,
                round(avg(`value`)-STD(`value`), 2) as first,
                round(avg(`value`), 2) as val,
                round(avg(`value`)+STD(`value`), 2) as last,
                round(max(`value`), 2) as max
                -- SUBSTRING_INDEX(GROUP_CONCAT(CAST(`value` AS CHAR) ORDER BY utc),',',-1) as last
            FROM  `".$this->SEN_TABLE."` 
            WHERE SEN_ID = ".$this->SEN_ID."
                AND utc >= '$since'
                AND utc < '$to'
        GROUP BY UTC_grp
        ORDER BY UTC_grp asc
        LIMIT 0 , 10000";
var_export($queryString);
        $query_result = $this->dataDB->query($queryString);
        var_export($query_result);
        $brut = $query_result->result_array($query_result);
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
    function wind($since='2013-01-01T00:00', $to='2037-12-31T23:59', $Granularity=360){

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

            $query_result = $this->dataDB->query($queryString);// ,

            $brut = $query_result->result_array($query_result);
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
    function histoWind($since='2013-01-01T00:00', $to='2037-12-31T23:59', $Granularity=360){

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
        $query_result = $this->dataDB->query($queryString);
        $brut = $query_result->result_array($query_result);
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
    function windrose_allInOne($since='2013-01-01', $to='2037-12-31T23:59', $Granularity=180){
        where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

    }
}