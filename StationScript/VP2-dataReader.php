<?php
/*
Script to read information from raw data return by the station
*/

// This class define a generic structure for measurement management.
class field
{
  protected $fieldOffset=-1; // field offset (starting at 0)
  protected $fieldlength=-1;   // field size/length
  protected $fieldDescription=null; // description of the field


// field offset
  function setFieldOffset($value)
  {
    if ($value > 0)
      { $this->fieldOffset = $value; }
    else
      { printf "Invalid `offset` value submitted (should be >0)."; }
  }
  function getFieldOffset()
  { return $this->fieldOffset; }

// field length
  function setFieldLength($value)
  {
    if ($value > 0)
      { $this->fieldLength = $value; }
    else
      { printf "Invalid `length` value submitted (should be >0)."; }
  }
  function getFieldLength()
  { return $this->fieldLength; }

// Explanation
  function setFieldDescription($value)
  {
    $this->fieldDescription = $value;
  }
  function getFieldDescription()
  { return $this->fieldDescription; }


  function __construct()
  {
  }
}







// +++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++HILOW Pac	++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++
class BarometerSection
{

  function __construct()
  {
    $this->setFieldOffset(0);
    $this->setFieldLength(16);
  }
}



// Object describing: DailyLowBarometer
class DailyLowBarometer extends field
{

  function __construct()
  {
    $this->setFieldOffset(0);
    $this->setFieldLength(2);
  }
}


// Object describing: DailyHighBarometer
class DailyHighBarometer extends field
{

  function __construct()
  {
    $this->setFieldOffset(2);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthLowBar
class MonthLowBar extends field
{

  function __construct()
  {
    $this->setFieldOffset(4);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthHighBar
class MonthHighBar extends field
{

  function __construct()
  {
    $this->setFieldOffset(6);
    $this->setFieldLength(2);
  }
}


// Object describing: YearLowBarometer
class YearLowBarometer extends field
{

  function __construct()
  {
    $this->setFieldOffset(8);
    $this->setFieldLength(2);
  }
}


// Object describing: YearHighBarometer
class YearHighBarometer extends field
{

  function __construct()
  {
    $this->setFieldOffset(10);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeofDayLowBar
class TimeofDayLowBar extends field
{

  function __construct()
  {
    $this->setFieldOffset(12);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeofDayHighBar
class TimeofDayHighBar extends field
{

  function __construct()
  {
    $this->setFieldOffset(14);
    $this->setFieldLength(2);
  }
}


// ################# WindSpeed Section #####################
class WindSpeedSection extends field
{

  function __construct()
  {
    $this->setFieldOffset(16);
    $this->setFieldLength(5);
  }
}


// Object describing: DailyHiWindSpeed
class DailyHiWindSpeed extends field
{

  function __construct()
  {
    $this->setFieldOffset(16);
    $this->setFieldLength(1);
  }
}


// Object describing: TimeofHiSpeed
class TimeofHiSpeed extends field
{

  function __construct()
  {
    $this->setFieldOffset(17);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthHiWindSpeed
class MonthHiWindSpeed extends field
{

  function __construct()
  {
    $this->setFieldOffset(19);
    $this->setFieldLength(1);
  }
}


// Object describing: YearHiWindSpeed
class YearHiWindSpeed extends field
{

  function __construct()
  {
    $this->setFieldOffset(20);
    $this->setFieldLength(1);
  }
}


// ################# InsideTemp Section #####################
class InsideTempSection extends field
{

  function __construct()
  {
    $this->setFieldOffset(21);
    $this->setFieldLength(16);
  }
}


// Object describing: DayHiInsideTemp
class DayHiInsideTemp extends field
{

  function __construct()
  {
    $this->setFieldOffset(21);
    $this->setFieldLength(2);
  }
}


// Object describing: DayLowInsideTemp
class DayLowInsideTemp extends field
{

  function __construct()
  {
    $this->setFieldOffset(23);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeDayHiInTemp
class TimeDayHiInTemp extends field
{

  function __construct()
  {
    $this->setFieldOffset(25);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeDayLowInTemp
class TimeDayLowInTemp extends field
{

  function __construct()
  {
    $this->setFieldOffset(27);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthLowInTemp
class MonthLowInTemp extends field
{

  function __construct()
  {
    $this->setFieldOffset(29);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthHiInTemp
class MonthHiInTemp extends field
{

  function __construct()
  {
    $this->setFieldOffset(31);
    $this->setFieldLength(2);
  }
}


// Object describing: YearLowInTemp
class YearLowInTemp extends field
{

  function __construct()
  {
    $this->setFieldOffset(33);
    $this->setFieldLength(2);
  }
}


// Object describing: YearHiInTemp
class YearHiInTemp extends field
{

  function __construct()
  {
    $this->setFieldOffset(35);
    $this->setFieldLength(2);
  }
}


// ################# InsideHumidity Section #####################
class InsideHumiditySection extends field
{

  function __construct()
  {
    $this->setFieldOffset(37);
    $this->setFieldLength(10);
  }
}


// Object describing: DayHiInHum
class DayHiInHum extends field
{

  function __construct()
  {
    $this->setFieldOffset(37);
    $this->setFieldLength(1);
  }
}


// Object describing: DayLowInHum
class DayLowInHum extends field
{

  function __construct()
  {
    $this->setFieldOffset(38);
    $this->setFieldLength(1);
  }
}


// Object describing: TimeDayHiInHum
class TimeDayHiInHum extends field
{

  function __construct()
  {
    $this->setFieldOffset(39);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeDayLowInHum
class TimeDayLowInHum extends field
{

  function __construct()
  {
    $this->setFieldOffset(41);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthHiInHum
class MonthHiInHum extends field
{

  function __construct()
  {
    $this->setFieldOffset(43);
    $this->setFieldLength(1);
  }
}


// Object describing: MonthLowInHum
class MonthLowInHum extends field
{

  function __construct()
  {
    $this->setFieldOffset(44);
    $this->setFieldLength(1);
  }
}


// Object describing: YearHiInHum
class YearHiInHum extends field
{

  function __construct()
  {
    $this->setFieldOffset(45);
    $this->setFieldLength(1);
  }
}


// Object describing: YearLowInHum
class YearLowInHum extends field
{

  function __construct()
  {
    $this->setFieldOffset(46);
    $this->setFieldLength(1);
  }
}


// ################# OutsideTemp Section #####################
class OutsideTempSection extends field
{

  function __construct()
  {
    $this->setFieldOffset(47);
    $this->setFieldLength(16);
  }
}


// Object describing: DayLowOutTemp
class DayLowOutTemp extends field
{

  function __construct()
  {
    $this->setFieldOffset(47);
    $this->setFieldLength(2);
  }
}


// Object describing: DayHiOutTemp
class DayHiOutTemp extends field
{

  function __construct()
  {
    $this->setFieldOffset(49);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeDayLowOutTemp
class TimeDayLowOutTemp extends field
{

  function __construct()
  {
    $this->setFieldOffset(51);
    $this->setFieldLength(2);
  }
}


// Object describing: TimeDayHiOutTemp
class TimeDayHiOutTemp extends field
{

  function __construct()
  {
    $this->setFieldOffset(53);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthHiOutTemp
class MonthHiOutTemp extends field
{

  function __construct()
  {
    $this->setFieldOffset(55);
    $this->setFieldLength(2);
  }
}


// Object describing: MonthLowOutTemp
class MonthLowOutTemp extends field
{

  function __construct()
  {
    $this->setFieldOffset(57);
    $this->setFieldLength(2);
  }
}


// Object describing: YearHiOutTemp
class YearHiOutTemp extends field
{

  function __construct()
  {
    $this->setFieldOffset(59);
    $this->setFieldLength(2);
  }
}


// Object describing: YearLowOutTemp
class YearLowOutTemp extends field
{

  function __construct()
  {
    $this->setFieldOffset(61);
    $this->setFieldLength(2);
  }
}

//

// ################# DewPoint Section #####################
class DewPointSection extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: DayLowDewPoint
class DayLowDewPoint extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: DayHiDewPoint
class DayHiDewPoint extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: TimeDayLowDewPoint
class TimeDayLowDewPoint extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: TimeDayHiDewPoint
class TimeDayHiDewPoint extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: MonthHiDewPoint
class MonthHiDewPoint extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: MonthLowDewPoint
class MonthLowDewPoint extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: YearHiDewPoint
class YearHiDewPoint extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: YearLowDewPoint
class YearLowDewPoint extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// ################# WindChill Section #####################
class WindChillSection extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: DayLowWindChill
class DayLowWindChill extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: TimeDayLowChill
class TimeDayLowChill extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: MonthLowWindChill
class MonthLowWindChill extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: YearLowWindChill
class YearLowWindChill extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// ################# HeatIndex Section #####################
class HeatIndexSection extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: DayHighHeat
class DayHighHeat extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: TimeofDayHighHeat
class TimeofDayHighHeat extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: MonthHighHeat
class MonthHighHeat extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: YearHighHeat
class YearHighHeat extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// ################# THSWIndex Section #####################
class THSWIndexSection extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: DayHighTHSW
class DayHighTHSW extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: TimeofDayHighTHSW
class TimeofDayHighTHSW extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: MonthHighTHSW
class MonthHighTHSW extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: YearHighTHSW
class YearHighTHSW extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// ################# SolarRadiation Section #####################
class SolarRadiationSection extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: DayHighSolarRad
class DayHighSolarRad extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: TimeofDayHighSolar
class TimeofDayHighSolar extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: MonthHighSolarRad
class MonthHighSolarRad extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: YearHighSolarRad
class YearHighSolarRad extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// ################# UV Section #####################
class UVSection extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: DayHighUV
class DayHighUV extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: TimeofDayHighUV
class TimeofDayHighUV extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: MonthHighUV
class MonthHighUV extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: YearHighUV
class YearHighUV extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// ################# RainRate Section #####################
class RainRateSection extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: DayHighRainRate
class DayHighRainRate extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: TimeofDayHighRainRate
class TimeofDayHighRainRate extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: HourHighRainRate
class HourHighRainRate extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: MonthHighRainRate
class MonthHighRainRate extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: YearHighRainRate
class YearHighRainRate extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: Extra/Leaf/SoilTemps
class Extra_Leaf_SoilTemps extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: DayLowTemperature
class DayLowTemperature extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: DayHiTemperature
class DayHiTemperature extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: TimeDayLowTemperature
class TimeDayLowTemperature extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: TimeDayHiTemperature
class TimeDayHiTemperature extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: MonthHiTemperature
class MonthHiTemperature extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: MonthLowTemperature
class MonthLowTemperature extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: YearHiTemperature
class YearHiTemperature extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: YearLowTemperature
class YearLowTemperature extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: Outside_ExtraHums
class Outside_ExtraHums extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}

// Object describing: DayLowHumidity
class DayLowHumidity extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: DayHiHumidity
class DayHiHumidity extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: TimeDayLowHumidity
class TimeDayLowHumidity extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: TimeDayHiHumidity
class TimeDayHiHumidity extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: MonthHiHumidity
class MonthHiHumidity extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: MonthLowHumidity
class MonthLowHumidity extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: YearHiHumidity
class YearHiHumidity extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: YearLowHumidity
class YearLowHumidity extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// ################# SoilMoisture Section #####################
class SoilMoistureSection extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: DayHiSoilMoisture
class DayHiSoilMoisture extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: TimeDayHiSoilMoisture
class TimeDayHiSoilMoisture extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: DayLowSoilMoisture
class DayLowSoilMoisture extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: TimeDayLowSoilMoisture
class TimeDayLowSoilMoisture extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: MonthLowSoilMoisture
class MonthLowSoilMoisture extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: MonthHiSoilMoisture
class MonthHiSoilMoisture extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: YearLowSoilMoisture
class YearLowSoilMoisture extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: YearHiSoilMoisture
class YearHiSoilMoisture extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// ################# LeafWetness Section #####################
class LeafWetnessSection extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: DayHiLeafWetness
class DayHiLeafWetness extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: TimeDayHiLeafWetness
class TimeDayHiLeafWetness extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: DayLowLeafWetness
class DayLowLeafWetness extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: TimeDayLowLeafWetness
class TimeDayLowLeafWetness extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: MonthLowLeafWetness
class MonthLowLeafWetness extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: MonthHiLeafWetness
class MonthHiLeafWetness extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: YearLowLeafWetness
class YearLowLeafWetness extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: YearHiLeafWetness
class YearHiLeafWetness extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}


// Object describing: CRC
class CRC extends field
{

  function __construct()
  {
    $this->setFieldOffset();
    $this->setFieldLength();
  }
}




// +++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++ INSTANCAITION ++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++
$DailyLowBarometer = new DailyLowBarometer();
$DailyHighBarometer = new DailyHighBarometer();
$MonthLowBar = new MonthLowBar();
$MonthHighBar = new MonthHighBar();
$YearLowBarometer = new YearLowBarometer();
$YearHighBarometer = new YearHighBarometer();
$TimeofDayLowBar = new TimeofDayLowBar();
$TimeofDayHighBar = new TimeofDayHighBar();
$WindSpeedSection = new WindSpeedSection();
$DailyHiWindSpeed = new DailyHiWindSpeed();
$TimeofHiSpeed = new TimeofHiSpeed();
$MonthHiWindSpeed = new MonthHiWindSpeed();
$YearHiWindSpeed = new YearHiWindSpeed();
$InsideTempSection = new InsideTempSection();
$DayHiInsideTemp = new DayHiInsideTemp();
$DayLowInsideTemp = new DayLowInsideTemp();
$TimeDayHiInTemp = new TimeDayHiInTemp();
$TimeDayLowInTemp = new TimeDayLowInTemp();
$MonthLowInTemp = new MonthLowInTemp();
$MonthHiInTemp = new MonthHiInTemp();
$YearLowInTemp = new YearLowInTemp();
$YearHiInTemp = new YearHiInTemp();
$InsideHumiditySection = new InsideHumiditySection();
$DayHiInHum = new DayHiInHum();
$DayLowInHum = new DayLowInHum();
$TimeDayHiInHum = new TimeDayHiInHum();
$TimeDayLowInHum = new TimeDayLowInHum();
$MonthHiInHum = new MonthHiInHum();
$MonthLowInHum = new MonthLowInHum();
$YearHiInHum = new YearHiInHum();
$YearLowInHum = new YearLowInHum();
$OutsideTempSection = new OutsideTempSection();
$DayLowOutTemp = new DayLowOutTemp();
$DayHiOutTemp = new DayHiOutTemp();
$TimeDayLowOutTemp = new TimeDayLowOutTemp();
$TimeDayHiOutTemp = new TimeDayHiOutTemp();
$MonthHiOutTemp = new MonthHiOutTemp();
$MonthLowOutTemp = new MonthLowOutTemp();
$YearHiOutTemp = new YearHiOutTemp();
$YearLowOutTemp = new YearLowOutTemp();
//
$DewPointSection = new DewPointSection();
$DayLowDewPoint = new DayLowDewPoint();
$DayHiDewPoint = new DayHiDewPoint();
$TimeDayLowDewPoint = new TimeDayLowDewPoint();
$TimeDayHiDewPoint = new TimeDayHiDewPoint();
$MonthHiDewPoint = new MonthHiDewPoint();
$MonthLowDewPoint = new MonthLowDewPoint();
$YearHiDewPoint = new YearHiDewPoint();
$YearLowDewPoint = new YearLowDewPoint();
$WindChillSection = new WindChillSection();
$DayLowWindChill = new DayLowWindChill();
$TimeDayLowChill = new TimeDayLowChill();
$MonthLowWindChill = new MonthLowWindChill();
$YearLowWindChill = new YearLowWindChill();
$HeatIndexSection = new HeatIndexSection();
$DayHighHeat = new DayHighHeat();
$TimeofDayHighHeat = new TimeofDayHighHeat();
$MonthHighHeat = new MonthHighHeat();
$YearHighHeat = new YearHighHeat();
$THSWIndexSection = new THSWIndexSection();
$DayHighTHSW = new DayHighTHSW();
$TimeofDayHighTHSW = new TimeofDayHighTHSW();
$MonthHighTHSW = new MonthHighTHSW();
$YearHighTHSW = new YearHighTHSW();
$SolarRadiationSection = new SolarRadiationSection();
$DayHighSolarRad = new DayHighSolarRad();
$TimeofDayHighSolar = new TimeofDayHighSolar();
$MonthHighSolarRad = new MonthHighSolarRad();
$YearHighSolarRad = new YearHighSolarRad();
$UVSection = new UVSection();
$DayHighUV = new DayHighUV();
$TimeofDayHighUV = new TimeofDayHighUV();
$MonthHighUV = new MonthHighUV();
$YearHighUV = new YearHighUV();
$RainRateSection = new RainRateSection();
$DayHighRainRate = new DayHighRainRate();
$TimeofDayHighRainRate = new TimeofDayHighRainRate();
$HourHighRainRate = new HourHighRainRate();
$MonthHighRainRate = new MonthHighRainRate();
$YearHighRainRate = new YearHighRainRate();
$Extra_Leaf_SoilTemps = new Extra_Leaf_SoilTemps();
//
$DayLowTemperature = new DayLowTemperature();
$DayHiTemperature = new DayHiTemperature();
$TimeDayLowTemperature = new TimeDayLowTemperature();
$TimeDayHiTemperature = new TimeDayHiTemperature();
$MonthHiTemperature = new MonthHiTemperature();
$MonthLowTemperature = new MonthLowTemperature();
$YearHiTemperature = new YearHiTemperature();
$YearLowTemperature = new YearLowTemperature();
$Outside_ExtraHums = $Outside_ExtraHums();
$DayLowHumidity = new DayLowHumidity();
$DayHiHumidity = new DayHiHumidity();
$TimeDayLowHumidity = new TimeDayLowHumidity();
$TimeDayHiHumidity = new TimeDayHiHumidity();
$MonthHiHumidity = new MonthHiHumidity();
$MonthLowHumidity = new MonthLowHumidity();
$YearHiHumidity = new YearHiHumidity();
$YearLowHumidity = new YearLowHumidity();
$SoilMoistureSection = new SoilMoistureSection();
$DayHiSoilMoisture = new DayHiSoilMoisture();
$TimeDayHiSoilMoisture = new TimeDayHiSoilMoisture();
$DayLowSoilMoisture = new DayLowSoilMoisture();
$TimeDayLowSoilMoisture = new TimeDayLowSoilMoisture();
$MonthLowSoilMoisture = new MonthLowSoilMoisture();
$MonthHiSoilMoisture = new MonthHiSoilMoisture();
$YearLowSoilMoisture = new YearLowSoilMoisture();
$YearHiSoilMoisture = new YearHiSoilMoisture();
$LeafWetnessSection = new LeafWetnessSection();
$DayHiLeafWetness = new DayHiLeafWetness();
$TimeDayHiLeafWetness = new TimeDayHiLeafWetness();
$DayLowLeafWetness = new DayLowLeafWetness();
$TimeDayLowLeafWetness = new TimeDayLowLeafWetness();
$MonthLowLeafWetness = new MonthLowLeafWetness();
$MonthHiLeafWetness = new MonthHiLeafWetness();
$YearLowLeafWetness = new YearLowLeafWetness();
$YearHiLeafWetness = new YearHiLeafWetness();
$CRC = new CRC();
//
$rawDataFilePath = '../VP2-data.brut';
$rawData = file_get_contents($rawDataFilePath);
echo strlen($raw);
?>
