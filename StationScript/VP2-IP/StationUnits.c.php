<?php
/**
		#################################################################################
		################	Function for RAW data convertion	#################
		#################################################################################
**/
	function ConvertStrRaw($Str) {// ConvertStrRaw return les donnees RAW au format Numerique dans un tableau...
		switch (strlen($Str)) {
			case 50:
			case 52:
				$modele = $this->DumpAfter;
				break;
			case 97:
			case 99:
				$modele = $this->Loop;
				break;
			case 436:
			case 438:
				$modele = $this->HiLow;
				break;
			case 4096:
				$modele = $this->EEPROM;
				break;
		}
		$x = array();
		foreach($modele as $key=>$val)
		{
			$val['str'] = substr ($Str, $val['pos'], $val['len']);
			$x[$key] = $this->$val['fn']($val['str']);
		}
		return $x;
	}
		require ($this->StationFolder.'StationUnits.c.php');

	function Bool($str) {// 
		return $this->hexToDec($str) ? true :false;
	}

	function Char2Signed($val) {
	// Char2Signed http://en.wikipedia.org/wiki/Two%27s_complement
	// return value between 0 - 255 into signed -128 - +127...Two's complement
		return (($val>>7)?(($val ^ 0xFF)+1)*(-1):$val);
	}
	function s2sc($str) {// String to Signed Char
		return Char2Signed($this->hexToDec(strrev($str)));
	}
	function s2c($str) {// String to Signed Char
		return ($this->hexToDec(strrev($str)));
	}

	function Short2Signed($val) {
	// Char2Signed http://en.wikipedia.org/wiki/Two%27s_complement
	// return value between 0 - 65532 into signed -32768 - +32767...Two's complement
		return (($val>>15)?(($val ^ 0xFFFF)+1)*(-1):$val);
	}
	function s2sSh($str) {// String to Signed Short
		return Short2Signed($this->hexToDec(strrev($str)));
	}
	function s2Sh($str) {// String to Signed Short
		return ($this->hexToDec(strrev($str)));
	}

	
	function Gain($str) {// ...
		return $this->hexToDec(strrev($str))/1000;
	}
	function Cal($str) {// ...
		return $this->hexToDec(strrev($str))/1000;
	}
	function Offset($str) {// ...
		return Short2Signed($this->hexToDec(strrev($str)));
	}
	function Alt($str) {// ...
		return Short2Signed($this->hexToDec(strrev($str)));
	}
	function GPS($str) {// ...
		return Short2Signed($this->hexToDec(strrev($str)))/10;
	}
	function Char($str) {// 
		return Char2Signed($this->hexToDec(strrev($str)));
	}
	function GMT($str) {// ...
		$val = Short2Signed($this->hexToDec(strrev($str)))/10
		return (int)($val/100).":".str_pad((abs($val)%100),2,"0",STR_PAD_LEFT));
	}
	function Station($str) {// ...
		return null;
	}
	function UnitBits($str) {// ...
		return array_combine(array("Wind","Rain","Elev","Temp","Barom"),
			array(
				!(($val&0xC0)>>6)?"mph":(((($val&0xC0)>>6)==1)?"m/s":(((($val&0xC0)>>6)==2)?"Km/h":"Knots")),
				(($val&0x20)>>5)?"mm":"in",
				(($val&0x10)>>4)?"m":"ft",
				!(($val&0x0C)>>2)?"1 °F":(((($val&0x0C)>>2)==1)?"0.1 °F":(((($val&0x0C)>>2)==2)?"1 °C":"0.1 °C")),
				!($val&0x03)?"0.01 in":((($val&0x03)==1)?"0.1 mm":((($val&0x03)==2)?"0.1 hpa":"0.1 mB")),
		));
	}
	function SetupBits($str) {// ...
		return array_combine(array("Longitude:","Latitude:","RainCupSize","WinCupSize","DayMonth","AM/PM","12/24"),
			array(
				(($val&0x80)>>7)?"East":"West",
				(($val&0x40)>>6)?"Nord":"South",
				!(($val&30)>>4)?"0.01 in":(((($val&30)>>4)==1)?"0.2 mm":"0.1 mm"),
				(($val&0x08)>>3)?"Large":"Small",
				(($val&0x04)>>2)?"Day/Month":"Month/Day",
				(($val&0x02)>>1)?"AM?":"PM?",
				($val&0x01)?"24h?":"AM/PM?",
			));
	}



	function Pressure($str) {// Pressure...
		$val = $this->hexToDec(strrev($str));
		return $val/1000;
	}
	function Temp($str) {// Temperature...
		$val = $this->hexToDec(strrev($str));
		return $this->Short2Signed($val)/10;
	}
	function Speed($str) {// Wind Speed...
		return $this->hexToDec($str);
	}
	function Samples($str) {// number of clic...
		$val = $this->hexToDec(strrev($str));
		return $val ? $val : false;
	}
	function UV($str) {// UV level...
		$val = $this->hexToDec($str);
		return $val==255 ? false : $val/10;
	}
	function Forecast($str) {// Forecast for next day...
		$val = $this->hexToDec($str);
		return $val;
	}

	function Rate($str) {// Percentage...
		$val = $this->hexToDec($str);
		return $val==255 ? false : $val;
	}
	function Moistures ($str){ // Humidite du sol
		return $this->Rate($str);
	}
	function Wetnesses($str) {// Humectometre...
		return $this->Rate($str);
	}

	function Radiation($str) {// Solar Radiation...
		$val = $this->hexToDec(strrev($str));
		return $val;
	}
	function ET1000($str) {// Evapotranspiration...
		return $this->hexToDec(strrev($str))/1000;
	}
	function ET100($str) {// Evapotranspiration...
		return $this->hexToDec(strrev($str))/100;
	}
	function Angle16($str) {// Wind Direction...
		$val = $this->hexToDec($str);
		if ($val<=15 && $val>=0)
			return $val*22.5; // $this->WinDir[$val];
		return false;
	}
	function Angle360($str) {// Wind Direction...
		$val = $this->hexToDec(strrev($str));
		if ($val==0)
			return null;
		elseif ($val>0 && $val<=360)
			return $val;
		return false;
	}
	function SpRev($str) {// Special revision...
		$val = $this->hexToDec($str);
		if ($val==255)
			return 'Rev A';
		return 'Rev B';
	}
	function SmallTemp($str) {// Temperature...
		$val = $this->hexToDec($str);
		return $val==255 ? false : $val-90;
	}
	function BTrend($str) {// ...
		$val = $this->hexToDec($str);
		return $this->Trend[$val];
	}
	function In_RainAlarms($str) {// ...
		$val = $this->hexToDec($str);
		return $val;
	}
	function OutAlarms($str) {// ...
		$val = $this->hexToDec($str);
		return $val;
	}
	function HumidityAlarms($str) {// ...
		$val = $this->hexToDec($str);
		return $val;
	}
	function Temp_HumAlarms($str) {// ...
		$val = $this->hexToDec($str);
		return $val;
	}
	function Soil_LeafAlarms($str) {// ...
		$val = $this->hexToDec($str);
		return $val;
	}
	function Voltage($str) {// ...
		return (($this->hexToDec(strrev($str))*300)/512)/100.0;
	}
	function Icons($str) {// ...
		return $this->hexToDec($str);
	}
?>