<?php
// ##############################################################################################
/// IX. Data Formats (See docs on pages 28, 29)
/// 3. DMP and DMPAFT data format
/// There are two different archived data formats. Rev "A" firmware, dated before April 24, 2002
/// uses the old format. Rev "B" firmware dated on or after April 24, 2002 uses the new format. The
/// fields up to ET are identical for both formats. The only differences are in the Soil, Leaf, Extra
// ##############################################################################################

	$this->DumpAfter = array (
	'DateStamp'		=>	array( 'pos' => 0,	'len' => 2,	'fn'=>'Raw2Date',	'SI'=>'UTC',	'min'=>0,	'max'=>0xFFFF,	'err'=>0xFFFF,	'unit'=> 'Date'	),
	'TimeStamp'		=>	array( 'pos' => 2,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>'UTC',	'min'=>0,	'max'=>0xFFFF,	'err'=>0xFFFF,	'unit'=> 'Time'	),
	'OutsideTemperature'	=>	array( 'pos' => 4,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>150,	'err'=>32767,	'unit'=> '°F'	),
	'HighOutTemperature'	=>	array( 'pos' => 6,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>150,	'err'=>-32768,	'unit'=> '°F'	),
	'LowOutTemperature'	=>	array( 'pos' => 8,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>150,	'err'=>-32767,	'unit'=> '°F'	),
	'Rainfall'		=>	array( 'pos' => 10,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'clic'	),
	'HighRainRate'		=>	array( 'pos' => 12,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'clic/h'),
	'Barometer'		=>	array( 'pos' => 14,	'len' => 2,	'fn'=>'Pressure',	'SI'=>'barSI',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'in.Hg'),
	'SolarRadiation'	=>	array( 'pos' => 16,	'len' => 2,	'fn'=>'Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>3000,	'err'=>32767,	'unit'=> 'W/m²'	),
	'NumberOfWindSamples'	=>	array( 'pos' => 18,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> '-'	),
	'InsideTemperature'	=>	array( 'pos' => 20,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>150,	'err'=>32767,	'unit'=> '°F'	),
	'InsideHumidity'	=>	array( 'pos' => 22,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'OutsideHumidity'	=>	array( 'pos' => 23,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'AverageWindSpeed'	=>	array( 'pos' => 24,	'len' => 1,	'fn'=>'Speed',		'SI'=>'mBySec',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'mph'	),
	'HighWindSpeed'		=>	array( 'pos' => 25,	'len' => 1,	'fn'=>'Speed',		'SI'=>'mBySec',	'min'=>0,	'max'=>0xFF,	'err'=>0,	'unit'=> 'mph'	),
	'DirectionofHiWindSpeed'=>	array( 'pos' => 26,	'len' => 1,	'fn'=>'Angle16',	'SI'=>NULL,	'min'=>0,	'max'=>16,	'err'=>255,	'unit'=> '°'	),
	'PrevailingWindDirection'=>	array( 'pos' => 27,	'len' => 1,	'fn'=>'Angle16',	'SI'=>NULL,	'min'=>0,	'max'=>16,	'err'=>255,	'unit'=> '°'	),
	'AverageUVIndex'	=>	array( 'pos' => 28,	'len' => 1,	'fn'=>'UV',		'SI'=>NULL,	'min'=>0,	'max'=>25,	'err'=>255,	'unit'=> '-'	),
	'ETLastHour'		=>	array( 'pos' => 29,	'len' => 1,	'fn'=>'ET_h',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>0,	'unit'=> 'mm'	),
	'HighSolarRadiation'	=>	array( 'pos' => 30,	'len' => 2,	'fn'=>'Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>2000,	'err'=>0,	'unit'=> 'W/m²'	),
	'HighUVIndex'		=>	array( 'pos' => 32,	'len' => 1,	'fn'=>'UV',		'SI'=>NULL,	'min'=>0,	'max'=>25,	'err'=>255,	'unit'=> 'W/m²'	),
	'ForecastRule'		=>	array( 'pos' => 33,	'len' => 1,	'fn'=>'Forecast',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>193,	'unit'=> '-'	),

	'Temp_leaf1'		=>	array( 'pos' => 34,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'Temp_leaf2'		=>	array( 'pos' => 35,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),

	'Wetnesses_leaf1'	=>	array( 'pos' => 36,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> '-'	),
	'Wetnesses_leaf2'	=>	array( 'pos' => 37,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> '-'	),

	'Temp_extra2'		=>	array( 'pos' => 38,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Temp_extra3'		=>	array( 'pos' => 39,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Temp_extra4'		=>	array( 'pos' => 40,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Temp_extra5'		=>	array( 'pos' => 41,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),

// 	'DownloadRecordType'	=>	array( 'pos' => 42,	'len' => 1,	'fn'=>'SpRev',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>null,	'unit'=> 'Rev'	),
	'Hum_extra1'		=>	array( 'pos' => 43,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'Hum_extra2'		=>	array( 'pos' => 44,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),

	'Temp_extra1'		=>	array( 'pos' => 45,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Temp_extra2'		=>	array( 'pos' => 46,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Temp_extra3'		=>	array( 'pos' => 47,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),

	'Moistures_soil1'	=>	array( 'pos' => 48,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'Moistures_soil2'	=>	array( 'pos' => 49,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'Moistures_soil3'	=>	array( 'pos' => 50,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'Moistures_soil4'	=>	array( 'pos' => 51,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	);

class DumpAfterObj {
	private $UTC;
	private $OutsideTemperature;
	private $HighOutTemperature;
	private $LowOutTemperature;
	private $Rainfall;
	private $HighRainRate;
	private $Barometer;
	private $SolarRadiation;
	private $NumberOfWindSamples;
	private $InsideTemperature;
	private $IndideHumidity;
	private $OutsideHumidity;
	private $AverageWindSpeed;
	private $HighWindSpeed;
	private $DirectionofHiWindSpeed;
	private $PrevailingWindDirection;
	private $AverageUVIndex;
	private $ETLastHour;
	private $HighSolarRadiation;
	private $HighUVIndex;
	private $ForecastRule;
	private $Temp_leaf1;
	private $Temp_leaf2;
	private $Wetnesses_leaf1;
	private $Wetnesses_leaf2;
	private $Temp_extra2;
	private $Temp_extra3;
	private $Temp_extra4;
	private $Temp_extra5;
	private $Hum_extra1;
	private $Hum_extra2;
	private $Temp_extra1;
	private $Moistures_soil1;
	private $Moistures_soil2;
	private $Moistures_soil3;
	private $Moistures_soil4;

	function __construct()	{
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
		$this-> = $val;
	}
	/**
	 * @ORM\Column(name=ARCH_UTC)
	 */
	function GetUTC($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetOutsideTemperature($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetHighOutTemperature($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetLowOutTemperature($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetRainfall($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetHighRainRate($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetBarometer($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetSolarRadiation($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetNumberOfWindSamples($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetInsideTemperature($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetIndideHumidity($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetOutsideHumidity($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetAverageWindSpeed($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetHighWindSpeed($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetDirectionofHiWindSpeed($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetPrevailingWindDirection($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetAverageUVIndex($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetETLastHour($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetHighSolarRadiation($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetHighUVIndex($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetForecastRule($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetTemp_leaf1($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetTemp_leaf2($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetWetnesses_leaf1($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetWetnesses_leaf2($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetTemp_extra2($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetTemp_extra3($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetTemp_extra4($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetTemp_extra5($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetHum_extra1($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetHum_extra2($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetTemp_extra1($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetMoistures_soil1($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetMoistures_soil2($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetMoistures_soil3($val) {
		return $this-> ;
	}
	/**
	 * @ORM\Column(name=ARCH_)
	 */
	function GetMoistures_soil4($val) {
		return $this-> ;
	}
}
?>