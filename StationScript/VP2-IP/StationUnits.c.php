<?php
// http://www.davisnet.com/support/weather/downloads/software_direct.asp?SoftCat=4&SoftwareID=172
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
			$mesure = $this->$val['fn']($val['str']);
			if ($mesure != $val['err'] && $mesure >= $val['min'] && $mesure <= $val['max'])
				$x[$key] = $mesure;
			else
				$x[$key] = NULL;
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
		return Char2Signed($this->hexToDec($str));
	}
	function s2uc($str) {// String to unSigned Char
		return ($this->hexToDec($str));
	}

	function Short2Signed($val) {
	// Char2Signed http://en.wikipedia.org/wiki/Two%27s_complement
	// return value between 0 - 65532 into signed -32768 - +32767...Two's complement
		return (($val>>15)?(($val ^ 0xFFFF)+1)*(-1):$val);
	}
	function s2sSht($str) {// String to Signed Short
		return $this->s2sSht($str);
	}
	function s2uSht($str) {// String to unSigned Short
		return ($this->hexToDec(strrev($str)));
	}

	
	function Gain($str) {// ...
		return $this->hexToDec(strrev($str))/1000;
	}
	function Cal($str) {// ...
		return $this->hexToDec(strrev($str))/1000;
	}
	function Offset($str) {// ...
		return $this->s2sSht($str);
	}
	function Alt($str) {// Altitude
		return $this->s2sSht($str);
	}
	function GPS($str) {// Position GPS
		return $this->s2sSht($str)/10;
	}
	function GMT($str) {// ...
		$val = $this->s2sSht($str)/10
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
		return $this->s2sSht($str)/10;
	}
	function SmallTemp($str) {// Temperature...
		$val = $this->hexToDec($str);
		return $val==255 ? false : $val-90;
	}
	function SmallTemp120($str) {// Temperature...
		$val = $this->hexToDec($str);
		return $val==255 ? false : $val-120;
	}

	function Speed($str) {// Wind Speed...
		return $this->hexToDec($str);
	}
	function Samples($str) {// number of clic...
		return $this->s2uSht($str);
	}

	function Radiation($str) {// Solar Radiation...
		return $this->s2sSht($str);
	}
	function ET1000($str) {// Evapotranspiration...
		return return $this->s2sSht($str)/1000;
	}
	function ET100($str) {// Evapotranspiration...
		return $this->s2us($str)/100;
	}
	function UV($str) {// UV level...
		$val = $this->s2uc($str);
		return $val==255 ? false : $val/10;
	}

	function Forecast($str) {// Forecast for next day...
		return $this->s2uc($str);
	}

	function Rate($str) {// Percentage...
		return $this->s2uc($str);
	}
	function Moistures ($str){ // Humidite du sol
		return $this->s2uc($str);
	}
	function Wetnesses($str) {// Humectometre...
		return $this->s2uc($str);
	}

	function Angle16($str) {// Wind Direction...
		return $this->s2uc($str);
	}
	function Angle360($str) {// Wind Direction...
		return $this->s2sSht($str);
	}
	function SpRev($str) {// Special revision...
		if ($this->hexToDec($str)==255)
			return 'Rev A';
		return 'Rev B';
	}
	function BTrend($str) {// ...
		return $this->Trend[$this->s2uc($str);];
	}

	function RainAlarms($str) {// ...
		return $this->s2sSht($str);
	}
	function HumidityAlarms($str) {// ...
		return $this->s2uc($str);
	}
*	function Temp_HumAlarms($str) {// ...
		$val = $this->hexToDec($str);
		return $val;
	}
*	function Soil_LeafAlarms($str) {// ...
		$val = $this->hexToDec($str);
		return $val;
	}
	function Voltage($str) {// Tension of inside battery
		return (($this->s2uSht($str)*300)/512)/100.0;
	}
	function Icons($str) {// ...
		return $this->s2uc($str);
	}
?>