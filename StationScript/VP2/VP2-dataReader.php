<?php
require_once "Fields.phpc";
require_once "Humidity.phpc";
require_once "Pressure.phpc";
require_once "Radiation.phpc";
require_once "Temperature.phpc";
require_once "Wind.phpc"

/*
Script to read information from raw data return by the station
*/

// +++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++ VAR DEFINITION ++++++++++++++++++++++
$measures = array(
	'DailyLowBarometer' => new DailyLowBarometer();
	'DailyHighBarometer' => new DailyHighBarometer();
	'MonthLowBar' => new MonthLowBar();
	'MonthHighBar' => new MonthHighBar();
	'YearLowBarometer' => new YearLowBarometer();
	'YearHighBarometer' => new YearHighBarometer();
	'TimeofDayLowBar' => new TimeofDayLowBar();
	'TimeofDayHighBar' => new TimeofDayHighBar();
	'WindSpeedSection' => new WindSpeedSection();
	'DailyHiWindSpeed' => new DailyHiWindSpeed();
	'TimeofHiSpeed' => new TimeofHiSpeed();
	'MonthHiWindSpeed' => new MonthHiWindSpeed();
	'YearHiWindSpeed' => new YearHiWindSpeed();
	'InsideTempSection' => new InsideTempSection();
	'DayHiInsideTemp' => new DayHiInsideTemp();
	'DayLowInsideTemp' => new DayLowInsideTemp();
	'TimeDayHiInTemp' => new TimeDayHiInTemp();
	'TimeDayLowInTemp' => new TimeDayLowInTemp();
	'MonthLowInTemp' => new MonthLowInTemp();
	'MonthHiInTemp' => new MonthHiInTemp();
	'YearLowInTemp' => new YearLowInTemp();
	'YearHiInTemp' => new YearHiInTemp();
	'InsideHumiditySection' => new InsideHumiditySection();
	'DayHiInHum' => new DayHiInHum();
	'DayLowInHum' => new DayLowInHum();
	'TimeDayHiInHum' => new TimeDayHiInHum();
	'TimeDayLowInHum' => new TimeDayLowInHum();
	'MonthHiInHum' => new MonthHiInHum();
	'MonthLowInHum' => new MonthLowInHum();
	'YearHiInHum' => new YearHiInHum();
	'YearLowInHum' => new YearLowInHum();
	'OutsideTempSection' => new OutsideTempSection();
	'DayLowOutTemp' => new DayLowOutTemp();
	'DayHiOutTemp' => new DayHiOutTemp();
	'TimeDayLowOutTemp' => new TimeDayLowOutTemp();
	'TimeDayHiOutTemp' => new TimeDayHiOutTemp();
	'MonthHiOutTemp' => new MonthHiOutTemp();
	'MonthLowOutTemp' => new MonthLowOutTemp();
	'YearHiOutTemp' => new YearHiOutTemp();
	'YearLowOutTemp' => new YearLowOutTemp();
	//
	'DewPointSection' => new DewPointSection();
	'DayLowDewPoint' => new DayLowDewPoint();
	'DayHiDewPoint' => new DayHiDewPoint();
	'TimeDayLowDewPoint' => new TimeDayLowDewPoint();
	'TimeDayHiDewPoint' => new TimeDayHiDewPoint();
	'MonthHiDewPoint' => new MonthHiDewPoint();
	'MonthLowDewPoint' => new MonthLowDewPoint();
	'YearHiDewPoint' => new YearHiDewPoint();
	'YearLowDewPoint' => new YearLowDewPoint();
	'WindChillSection' => new WindChillSection();
	'DayLowWindChill' => new DayLowWindChill();
	'TimeDayLowChill' => new TimeDayLowChill();
	'MonthLowWindChill' => new MonthLowWindChill();
	'YearLowWindChill' => new YearLowWindChill();
	'HeatIndexSection' => new HeatIndexSection();
	'DayHighHeat' => new DayHighHeat();
	'TimeofDayHighHeat' => new TimeofDayHighHeat();
	'MonthHighHeat' => new MonthHighHeat();
	'YearHighHeat' => new YearHighHeat();
	'THSWIndexSection' => new THSWIndexSection();
	'DayHighTHSW' => new DayHighTHSW();
	'TimeofDayHighTHSW' => new TimeofDayHighTHSW();
	'MonthHighTHSW' => new MonthHighTHSW();
	'YearHighTHSW' => new YearHighTHSW();
	'SolarRadiationSection' => new SolarRadiationSection();
	'DayHighSolarRad' => new DayHighSolarRad();
	'TimeofDayHighSolar' => new TimeofDayHighSolar();
	'MonthHighSolarRad' => new MonthHighSolarRad();
	'YearHighSolarRad' => new YearHighSolarRad();
	'UVSection' => new UVSection();
	'DayHighUV' => new DayHighUV();
	'TimeofDayHighUV' => new TimeofDayHighUV();
	'MonthHighUV' => new MonthHighUV();
	'YearHighUV' => new YearHighUV();
	'RainRateSection' => new RainRateSection();
	'DayHighRainRate' => new DayHighRainRate();
	'TimeofDayHighRainRate' => new TimeofDayHighRainRate();
	'HourHighRainRate' => new HourHighRainRate();
	'MonthHighRainRate' => new MonthHighRainRate();
	'YearHighRainRate' => new YearHighRainRate();
	'Extra_Leaf_SoilTemps' => new Extra_Leaf_SoilTemps();
	//
	'DayLowTemperature' => new DayLowTemperature();
	'DayHiTemperature' => new DayHiTemperature();
	'TimeDayLowTemperature' => new TimeDayLowTemperature();
	'TimeDayHiTemperature' => new TimeDayHiTemperature();
	'MonthHiTemperature' => new MonthHiTemperature();
	'MonthLowTemperature' => new MonthLowTemperature();
	'YearHiTemperature' => new YearHiTemperature();
	'YearLowTemperature' => new YearLowTemperature();
	'Outside_ExtraHums' => $Outside_ExtraHums();
	'DayLowHumidity' => new DayLowHumidity();
	'DayHiHumidity' => new DayHiHumidity();
	'TimeDayLowHumidity' => new TimeDayLowHumidity();
	'TimeDayHiHumidity' => new TimeDayHiHumidity();
	'MonthHiHumidity' => new MonthHiHumidity();
	'MonthLowHumidity' => new MonthLowHumidity();
	'YearHiHumidity' => new YearHiHumidity();
	'YearLowHumidity' => new YearLowHumidity();
	'SoilMoistureSection' => new SoilMoistureSection();
	'DayHiSoilMoisture' => new DayHiSoilMoisture();
	'TimeDayHiSoilMoisture' => new TimeDayHiSoilMoisture();
	'DayLowSoilMoisture' => new DayLowSoilMoisture();
	'TimeDayLowSoilMoisture' => new TimeDayLowSoilMoisture();
	'MonthLowSoilMoisture' => new MonthLowSoilMoisture();
	'MonthHiSoilMoisture' => new MonthHiSoilMoisture();
	'YearLowSoilMoisture' => new YearLowSoilMoisture();
	'YearHiSoilMoisture' => new YearHiSoilMoisture();
	'LeafWetnessSection' => new LeafWetnessSection();
	'DayHiLeafWetness' => new DayHiLeafWetness();
	'TimeDayHiLeafWetness' => new TimeDayHiLeafWetness();
	'DayLowLeafWetness' => new DayLowLeafWetness();
	'TimeDayLowLeafWetness' => new TimeDayLowLeafWetness();
	'MonthLowLeafWetness' => new MonthLowLeafWetness();
	'MonthHiLeafWetness' => new MonthHiLeafWetness();
	'YearLowLeafWetness' => new YearLowLeafWetness();
	'YearHiLeafWetness' => new YearHiLeafWetness();
	'CRC' => new CRC();
//

// +++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++ VAR DEFINITION ++++++++++++++++++++++
$rawDataFilePath = '../VP2-data.brut';
$rawData = file_get_contents($rawDataFilePath);

foreach ($measures as $measureKey => $measureObject)
{
	printf("%s[%s]: from %s to %d",
		$measureKey,
		$measureObject->getFieldDescription(),
		$measureObject->getFieldOffset,
		$measureObject->getFieldLength()
	);
}
echo strlen($raw);




// +++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++ CLASS DEFINITION	 ++++++++++++++++++
class BarometerSection extends Pressure
{

  function __construct()
  {
    $this->setFieldOffset(0);
    $this->setFieldLength(16);
  }
}



// Object describing: DailyLowBarometer
class DailyLowBarometer extends Pressure
{

  function __construct()
  {
    $this->setFieldOffset(0);
    $this->setFieldLength(2);
  }
}


// Object describing: DailyHighBarometer
class DailyHighBarometer extends Pressure
{

  function __construct()
  {
    $this->setFieldOffset(2);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthLowBar
class MonthLowBar extends Pressure
{

  function __construct()
  {
    $this->setFieldOffset(4);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthHighBar
class MonthHighBar extends Pressure
{

  function __construct()
  {
    $this->setFieldOffset(6);
    $this->setFieldLength(2);
  }
}


// Object describing: YearLowBarometer
class YearLowBarometer extends Pressure
{

  function __construct()
  {
    $this->setFieldOffset(8);
    $this->setFieldLength(2);
  }
}


// Object describing: YearHighBarometer
class YearHighBarometer extends Pressure
{

  function __construct()
  {
    $this->setFieldOffset(10);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeofDayLowBar
class TimeofDayLowBar extends Pressure
{

  function __construct()
  {
    $this->setFieldOffset(12);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeofDayHighBar
class TimeofDayHighBar extends Pressure
{

  function __construct()
  {
    $this->setFieldOffset(14);
    $this->setFieldLength(2);
  }
}


// ################# WindSpeed Section #####################
class WindSpeedSection extends Wind
{

  function __construct()
  {
    $this->setFieldOffset(16);
    $this->setFieldLength(5);
  }
}


// Object describing: DailyHiWindSpeed
class DailyHiWindSpeed extends Wind
{

  function __construct()
  {
    $this->setFieldOffset(16);
    $this->setFieldLength(1);
  }
}


// Object describing: TimeofHiSpeed
class TimeofHiSpeed extends Wind
{

  function __construct()
  {
    $this->setFieldOffset(17);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthHiWindSpeed
class MonthHiWindSpeed extends Wind
{

  function __construct()
  {
    $this->setFieldOffset(19);
    $this->setFieldLength(1);
  }
}


// Object describing: YearHiWindSpeed
class YearHiWindSpeed extends Wind
{

  function __construct()
  {
    $this->setFieldOffset(20);
    $this->setFieldLength(1);
  }
}


// ################# InsideTemp Section #####################
class InsideTempSection extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(21);
    $this->setFieldLength(16);
  }
}


// Object describing: DayHiInsideTemp
class DayHiInsideTemp extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(21);
    $this->setFieldLength(2);
  }
}


// Object describing: DayLowInsideTemp
class DayLowInsideTemp extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(23);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeDayHiInTemp
class TimeDayHiInTemp extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(25);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeDayLowInTemp
class TimeDayLowInTemp extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(27);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthLowInTemp
class MonthLowInTemp extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(29);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthHiInTemp
class MonthHiInTemp extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(31);
    $this->setFieldLength(2);
  }
}


// Object describing: YearLowInTemp
class YearLowInTemp extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(33);
    $this->setFieldLength(2);
  }
}


// Object describing: YearHiInTemp
class YearHiInTemp extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(35);
    $this->setFieldLength(2);
  }
}


// ################# InsideHumidity Section #####################
class InsideHumiditySection extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(37);
    $this->setFieldLength(10);
  }
}


// Object describing: DayHiInHum
class DayHiInHum extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(37);
    $this->setFieldLength(1);
  }
}


// Object describing: DayLowInHum
class DayLowInHum extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(38);
    $this->setFieldLength(1);
  }
}


// Object describing: TimeDayHiInHum
class TimeDayHiInHum extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(39);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeDayLowInHum
class TimeDayLowInHum extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(41);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthHiInHum
class MonthHiInHum extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(43);
    $this->setFieldLength(1);
  }
}


// Object describing: MonthLowInHum
class MonthLowInHum extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(44);
    $this->setFieldLength(1);
  }
}


// Object describing: YearHiInHum
class YearHiInHum extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(45);
    $this->setFieldLength(1);
  }
}


// Object describing: YearLowInHum
class YearLowInHum extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(46);
    $this->setFieldLength(1);
  }
}


// ################# OutsideTemp Section #####################
class OutsideTempSection extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(47);
    $this->setFieldLength(16);
  }
}


// Object describing: DayLowOutTemp
class DayLowOutTemp extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(47);
    $this->setFieldLength(2);
  }
}


// Object describing: DayHiOutTemp
class DayHiOutTemp extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(49);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeDayLowOutTemp
class TimeDayLowOutTemp extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(51);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeDayHiOutTemp
class TimeDayHiOutTemp extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(53);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthHiOutTemp
class MonthHiOutTemp extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(55);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthLowOutTemp
class MonthLowOutTemp extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(57);
    $this->setFieldLength(2);
  }
}


// Object describing: YearHiOutTemp
class YearHiOutTemp extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(59);
    $this->setFieldLength(2);
  }
}


// Object describing: YearLowOutTemp
class YearLowOutTemp extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(61);
    $this->setFieldLength(2);
  }
}

//

// ################# DewPoint Section #####################
class DewPointSection extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(63);
    $this->setFieldLength(16);
  }
}


// Object describing: DayLowDewPoint
class DayLowDewPoint extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(63);
    $this->setFieldLength(2);
  }
}


// Object describing: DayHiDewPoint
class DayHiDewPoint extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(65);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeDayLowDewPoint
class TimeDayLowDewPoint extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(67);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeDayHiDewPoint
class TimeDayHiDewPoint extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(69);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthHiDewPoint
class MonthHiDewPoint extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(71);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthLowDewPoint
class MonthLowDewPoint extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(73);
    $this->setFieldLength(2);
  }
}


// Object describing: YearHiDewPoint
class YearHiDewPoint extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(75);
    $this->setFieldLength(2);
  }
}


// Object describing: YearLowDewPoint
class YearLowDewPoint extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(77);
    $this->setFieldLength(2);
  }
}


// ################# WindChill Section #####################
class WindChillSection extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(79);
    $this->setFieldLength(8);
  }
}


// Object describing: DayLowWindChill
class DayLowWindChill extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(79);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeDayLowChill
class TimeDayLowChill extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(81);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthLowWindChill
class MonthLowWindChill extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(83);
    $this->setFieldLength(2);
  }
}


// Object describing: YearLowWindChill
class YearLowWindChill extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(85);
    $this->setFieldLength(2);
  }
}


// ################# HeatIndex Section #####################
class HeatIndexSection extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(87);
    $this->setFieldLength(8);
  }
}


// Object describing: DayHighHeat
class DayHighHeat extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(87);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeofDayHighHeat
class TimeofDayHighHeat extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(89);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthHighHeat
class MonthHighHeat extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(91);
    $this->setFieldLength(2);
  }
}


// Object describing: YearHighHeat
class YearHighHeat extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(93);
    $this->setFieldLength(2);
  }
}


// ################# THSWIndex Section #####################
class THSWIndexSection extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(95);
    $this->setFieldLength(8);
  }
}


// Object describing: DayHighTHSW
class DayHighTHSW extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(95);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeofDayHighTHSW
class TimeofDayHighTHSW extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(97);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthHighTHSW
class MonthHighTHSW extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(99);
    $this->setFieldLength(2);
  }
}


// Object describing: YearHighTHSW
class YearHighTHSW extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(101);
    $this->setFieldLength(2);
  }
}


// ################# SolarRadiation Section #####################
class SolarRadiationSection extends Radiation
{

  function __construct()
  {
    $this->setFieldOffset(103);
    $this->setFieldLength(8);
  }
}


// Object describing: DayHighSolarRad
class DayHighSolarRad extends Radiation
{

  function __construct()
  {
    $this->setFieldOffset(103);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeofDayHighSolar
class TimeofDayHighSolar extends Radiation
{

  function __construct()
  {
    $this->setFieldOffset(105);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthHighSolarRad
class MonthHighSolarRad extends Radiation
{

  function __construct()
  {
    $this->setFieldOffset(107);
    $this->setFieldLength(2);
  }
}


// Object describing: YearHighSolarRad
class YearHighSolarRad extends Radiation
{

  function __construct()
  {
    $this->setFieldOffset(109);
    $this->setFieldLength(2);
  }
}


// ################# UV Section #####################
class UVSection extends Radiation
{

  function __construct()
  {
    $this->setFieldOffset(111);
    $this->setFieldLength(5);
  }
}


// Object describing: DayHighUV
class DayHighUV extends Radiation
{

  function __construct()
  {
    $this->setFieldOffset(111);
    $this->setFieldLength(1);
  }
}


// Object describing: TimeofDayHighUV
class TimeofDayHighUV extends Radiation
{

  function __construct()
  {
    $this->setFieldOffset(112);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthHighUV
class MonthHighUV extends Radiation
{

  function __construct()
  {
    $this->setFieldOffset(114);
    $this->setFieldLength(1);
  }
}


// Object describing: YearHighUV
class YearHighUV extends Radiation
{

  function __construct()
  {
    $this->setFieldOffset(115);
    $this->setFieldLength(1);
  }
}


// ################# RainRate Section #####################
class RainRateSection extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(116);
    $this->setFieldLength(10);
  }
}


// Object describing: DayHighRainRate
class DayHighRainRate extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(116);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeofDayHighRainRate
class TimeofDayHighRainRate extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(118);
    $this->setFieldLength(2);
  }
}


// Object describing: HourHighRainRate
class HourHighRainRate extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(120);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthHighRainRate
class MonthHighRainRate extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(122);
    $this->setFieldLength(2);
  }
}


// Object describing: YearHighRainRate
class YearHighRainRate extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(124);
    $this->setFieldLength(2);
  }
}


// ################# Extra/Leaf/Soil Temps #####################
// Each field has 15 entries.
// Indexes 0 – 6 = Extra Temperatures 2 – 8
// Indexes 7 – 10 = Leaf Temperatures 1 – 4
// Indexes 11 – 14 = Soil Temperatures 1 – 4
class Extra_Leaf_SoilTemps extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(126);
    $this->setFieldLength(150);
  }
}


// Object describing: DayLowTemperature
// (15 * 1)
class DayLowTemperature extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(126);
    $this->setFieldLength(15);
  }
}


// Object describing: DayHiTemperature
// (15 * 1)
class DayHiTemperature extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(141);
    $this->setFieldLength(15);
  }
}


// Object describing: TimeDayLowTemperature
// (15 * 2)
class TimeDayLowTemperature extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(156);
    $this->setFieldLength(30);
  }
}


// Object describing: TimeDayHiTemperature
// (15 * 2)
class TimeDayHiTemperature extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(186);
    $this->setFieldLength(30);
  }
}


// Object describing: MonthHiTemperature
// (15 * 1)
class MonthHiTemperature extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(216);
    $this->setFieldLength(15);
  }
}


// Object describing: MonthLowTemperature
// (15 * 1)
class MonthLowTemperature extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(231);
    $this->setFieldLength(15);
  }
}


// Object describing: YearHiTemperature
// (15 * 1)
class YearHiTemperature extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(246);
    $this->setFieldLength(15);
  }
}


// Object describing: YearLowTemperature
// (15 * 1)
class YearLowTemperature extends Temperature
{

  function __construct()
  {
    $this->setFieldOffset(261);
    $this->setFieldLength(15);
  }
}


// Object describing: Outside_ExtraHums
// Each field has 8 entries
// Index 0 = Outside Humidity
// Index 1 – 7 = Extra Humidities 2 – 8
class Outside_ExtraHums extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(276);
    $this->setFieldLength(80);
  }
}

// Object describing: DayLowHumidity
// (8 * 1)
class DayLowHumidity extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(276);
    $this->setFieldLength(8);
  }
}


// Object describing: DayHiHumidity
// (8 * 1)
class DayHiHumidity extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(284);
    $this->setFieldLength(8);
  }
}


// Object describing: TimeDayLowHumidity
// (8 * 2)
class TimeDayLowHumidity extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(292);
    $this->setFieldLength(16);
  }
}


// Object describing: TimeDayHiHumidity
// (8 * 2)
class TimeDayHiHumidity extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(308);
    $this->setFieldLength(16);
  }
}


// Object describing: MonthHiHumidity
// (8 * 1)
class MonthHiHumidity extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(324);
    $this->setFieldLength(8);
  }
}


// Object describing: MonthLowHumidity
// (8 * 1)
class MonthLowHumidity extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(332);
    $this->setFieldLength(8);
  }
}


// Object describing: YearHiHumidity
// (8 * 1)
class YearHiHumidity extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(340);
    $this->setFieldLength(8);
  }
}


// Object describing: YearLowHumidity
// (8 * 1)
class YearLowHumidity extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(348);
    $this->setFieldLength(8);
  }
}


// ################# SoilMoisture Section #####################
// Each field has 4 entries.
// Indexes 0 – 3 = Soil Moistures 1 – 4
class SoilMoistureSection extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(356);
    $this->setFieldLength(40);
  }
}


// Object describing: DayHiSoilMoisture
// (4 * 1)
class DayHiSoilMoisture extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(356);
    $this->setFieldLength(4);
  }
}


// Object describing: TimeDayHiSoilMoisture
// (4 * 2)
class TimeDayHiSoilMoisture extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(360);
    $this->setFieldLength(8);
  }
}


// Object describing: DayLowSoilMoisture
// (4 * 1)
class DayLowSoilMoisture extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(368);
    $this->setFieldLength(4);
  }
}


// Object describing: TimeDayLowSoilMoisture
// (4 * 2)
class TimeDayLowSoilMoisture extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(372);
    $this->setFieldLength(8);
  }
}


// Object describing: MonthLowSoilMoisture
// (4 * 1)
class MonthLowSoilMoisture extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(380);
    $this->setFieldLength(4);
  }
}


// Object describing: MonthHiSoilMoisture
// (4 * 1)
class MonthHiSoilMoisture extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(384);
    $this->setFieldLength(4);
  }
}


// Object describing: YearLowSoilMoisture
// (4 * 1)
class YearLowSoilMoisture extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(388);
    $this->setFieldLength(4);
  }
}


// Object describing: YearHiSoilMoisture
// (4 * 1)
class YearHiSoilMoisture extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(392);
    $this->setFieldLength(4);
  }
}


// ################# LeafWetness Section #####################
// Each field has 4 entries.
// Indexes 0 – 3 = Leaf Wetness 1 – 4
class LeafWetnessSection extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(396);
    $this->setFieldLength(40);
  }
}


// Object describing: DayHiLeafWetness
// (4 * 1)
class DayHiLeafWetness extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(396);
    $this->setFieldLength(4);
  }
}


// Object describing: TimeDayHiLeafWetness
// (4 * 2)
class TimeDayHiLeafWetness extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(400);
    $this->setFieldLength(8);
  }
}


// Object describing: DayLowLeafWetness
// (4 * 1)
class DayLowLeafWetness extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(408);
    $this->setFieldLength(4);
  }
}


// Object describing: TimeDayLowLeafWetness
// (4 * 2)
class TimeDayLowLeafWetness extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(412);
    $this->setFieldLength(8);
  }
}


// Object describing: MonthLowLeafWetness
// (4 * 1)
class MonthLowLeafWetness extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(420);
    $this->setFieldLength(4);
  }
}


// Object describing: MonthHiLeafWetness
// (4 * 1)
class MonthHiLeafWetness extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(424);
    $this->setFieldLength(4);
  }
}


// Object describing: YearLowLeafWetness
// (4 * 1)
class YearLowLeafWetness extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(428);
    $this->setFieldLength(4);
  }
}


// Object describing: YearHiLeafWetness
// (4 * 1)
class YearHiLeafWetness extends Humidity
{

  function __construct()
  {
    $this->setFieldOffset(432);
    $this->setFieldLength(4);
  }
}


// Object describing: CRC
class CRC extends Fields
{

  function __construct()
  {
    $this->setFieldOffset(436);
    $this->setFieldLength(2);
  }
}



?>
