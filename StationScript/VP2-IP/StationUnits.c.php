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

	function Char2Signed($val) {
	// Short2Signed return value between 0 - 255 into signed -127 - +128...Two's complement
		return (($val>>7)?(($val ^ 0xFF)+1)*(-1):$val);
	}
	function Short2Signed($val) {
	// Short2Signed return value between 0 - 65532 into signed -32000 - +32000...Two's complement
		return (($val>>15)?(($val ^ 0xFFFF)+1)*(-1):$val);
	}

	function Pressure($str) {// Pressure...
		$val = $this->hexToDec(strrev($str));
		return $val/1000;
	}
	function Temp($str) {// Temperature...
		$val = $this->hexToDec(strrev($str));
		return $this->Short2Signed($val)/10;
	}
	function Wetnesses($str) {// Humectometre...
		return $this->hexToDec($str)==255?false:$this->hexToDec($str);
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
	function Moistures ($str){ // Humidite du sol
		$val = $this->hexToDec($str);
		return $val==255 ? false : $val;
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