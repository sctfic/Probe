<?php
require_once 'Loop.phpc';


$measures =array(
  'Barometer' => new Barometer(7, 2),
  'BarTrend' => new BarTrend(3, 1),
  'ConsoleBatteryVoltage' => new ConsoleBatteryVoltage(87, 2),
  'DayET' => new DayET(56, 2),
  'DayRain' => new DayRain(50, 2),
  'ExtraHumidties' => new ExtraHumidties(34, 7),
  'ExtraTemperatures' => new ExtraTemperatures(18, 7),
  'ExtraTempHumAlarms' => new ExtraTempHumAlarms(74, 8),
  'ForecastRulenumber' => new ForecastRulenumber(90, 1),
  'InsideAlarms' => new InsideAlarms(70, 1),
  'InsideHumidity' => new InsideHumidity(11, 1),
  'InsideTemperature' => new InsideTemperature(9, 2),
  'LeafTemperatures' => new LeafTemperatures(29, 4),
  'LeafWetnesses' => new LeafWetnesses(66, 4),
  'MonthET' => new MonthET(58, 2),
  'MonthRain' => new MonthRain(52, 2),
  'NextRecord' => new NextRecord(5, 2),
  'OutsideAlarms' => new OutsideAlarms(72, 2),
  'OutsideHumidity' => new OutsideHumidity(33, 1),
  'OutsideTemperature' => new OutsideTemperature(12, 2),
  'PacketType' => new PacketType(4, 1),
  'RainAlarms' => new RainAlarms(71, 1),
  'RainRate' => new RainRate(41, 2),
  'SoilLeafAlarms' => new SoilLeafAlarms(82, 4),
  'SoilMoistures' => new SoilMoistures(62, 4),
  'SoilTemperatures' => new SoilTemperatures(25, 4),
  'SolarRadiation' => new SolarRadiation(44, 2),
  'StartDateOfCurrentStorm' => new StartDateOfCurrentStorm(48, 2),
  'StormRain' => new StormRain(46, 2),
  'TenMinAvgWindSpeed' => new TenMinAvgWindSpeed(15, 1),
  'TimeOfSunrise' => new TimeOfSunrise(91, 2),
  'TimeOfSunset' => new TimeOfSunset(93, 2),
  'TransmitterBatteryStatus' => new TransmitterBatteryStatus(86, 1),
  'UV' => new UV(43, 1),
  'WindDirection' => new WindDirection(16, 2),
  'WindSpeed' => new WindSpeed(14, 1),
  'YearET' => new YearET(60, 2),
  'YearRain' => new YearRain(54, 2),
);

$rawDataFilePath = dirname(__FILE__).'/VP2-data.brut';
$rawDataString = file_get_contents($rawDataFilePath);

foreach ($measures as $measureKey => $measureObject)
{
  printf(
  "%s\t(%s), \tfrom %s+%d = raw[%s] hex<>dec[%s|%s]]\n",
  $measureKey,
  $measureObject->getFieldDescription(),
  $measureObject->getFieldOffset(),
  $measureObject->getFieldSize(),
  $measureObject->extractRawField($rawDataString),
  Fields::hexToDec($measureObject->extractRawField($rawDataString)), // get correct value
  bin2hex($measureObject->extractRawField($rawDataString))
  );
}

?>