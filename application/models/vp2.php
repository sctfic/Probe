<?php // clear;php5 -f /var/www/WsWds/cli.php 'cron'
class vp2 extends CI_Model {
	protected $fp=NULL;	// Pointer of VP2 Connection
	protected $backLightScreen=FALSE; // actual state of backlight screen
	public $_version = 0.23;
	protected $conf = null;
	
	protected $prep_EAV = NULL;
	protected $key_EAV = array(':id', ':val', ':sensorID');

	protected $prep_SENSOR = NULL;
	protected $key_SENSOR = array(':NAME', ':HUMAN_NAME', ':DESCRIPT', ':MIN_REAL', ':MAX_REAL', ':UNITE_SIGN', ':DEF_PLOT', ':MAX_ALARM', ':MIN_ALARM', ':LAST_CALIBRATE', ':CALIBRATE_PERIOD');

	protected $prep_VARIOUS = NULL;
	protected $key_VARIOUS = array(':UTC_date', ':rainfall', ':max_rainfall', ':P0', ':srad', ':max_srad', ':wspeed', ':max_wspeed', ':dir_higtspeed', ':dir_dominant', ':uv', ':max_uv', ':forecast', ':et');

	protected $T_12H = NULL;
	
	protected $dataDB = NULL;
	protected $current_data = NULL;
	
	function __construct($conf)
	{
		parent::__construct();
		log_message('init',  __FUNCTION__.'('.__CLASS__.' ('.$conf['_name'].':'.($base = $conf['_db']).') '.")\n".__FILE__.' ['.__LINE__.']');
		$this->conf = $conf;
		$this->load->helper(array('binary','s.i.converter'));
		global $auge, $altitude, $latitude, $longitude, $Zone, $WindCup;
		$auge = $conf['rain:collector:size'];
		$WindCup = $conf['wind:cup:large'];
		$altitude = $conf['geo:elevation:ocean'];
		$latitude = $conf['geo:latitude:nordvalue'];
		$longitude = $conf['geo:longitude:estvalue'];
		$Zone = $conf['geo:time:zone'];
		
	/**
	[bar::unit] => 0
	[bar:calibration:cal] => 0.004
	[bar:calibration:gain] => 0
	[bar:calibration:offset] => -36
	[daylight:savings:enable] => 0
	[daylight:savings:manual] => 1
	[geo:elevation:ocean] => 240
	[geo:elevation:unit] => 0
>	[geo:latitude:nord] => 44.5
? >	[geo:latitude:north] => 0
? >	[geo:longitude:east] => 0
>	[geo:longitude:est] => 0.3
	[geo:time:zone] => 21
	[hum:calibration:@33%] => -1
	[hum:calibration:@80%] => -1
	[rain::seasonstart] => 1
	[rain:collector:size] => 0
	[rain:display:unit] => 0
	[temp:display:unit] => 0
	[temp:log:average] => 1
	[time:archive:period] => 5
	[time:format:day/month] => 0
	[time:gmt:enable] => 1
	[time:gmt:offset] => 2:00
	[time:mode:am/pm] => 0
	[time:mode:isam] => 0
	[wind:cup:large] => 0
	[wind:display:unit] => 0
	**/

		require (APPPATH.'models/vp2/EepromDumpAfter.h.php');
		require (APPPATH.'models/vp2/EepromLoop.h.php');
		require (APPPATH.'models/vp2/EepromHiLow.h.php');
		require (APPPATH.'models/vp2/EepromConfig.h.php');
		
		$this->dataDB = $this->load->database($base, TRUE);
		
		$this->prep_EAV_T = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO TA_TEMPERATURE (ID, VALUE, SEN_ID) 
				VALUES (:id, :val, :sensorID);');
		$this->prep_EAV_H = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO TA_HUMIDITY (ID, VALUE, SEN_ID) 
				VALUES (:id, :val, :sensorID);');
		$this->prep_EAV_W = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO TA_WETNESSES (ID, VALUE, SEN_ID) 
				VALUES (:id, :val, :sensorID);');
		$this->prep_EAV_M = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO TA_MOISTURE (ID, VALUE, SEN_ID) 
				VALUES (:id, :val, :sensorID);');
		$this->prep_SENSOR = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO `TR_SENSOR` 
					(SEN_NAME, SEN_HUMAN_NAME, SEN_DESCRIPTIF, SEN_MIN_REALISTIC, SEN_MAX_REALISTIC, SEN_UNITE_SIGN, SEN_DEF_PLOT, SEN_MAX_ALARM, SEN_MIN_ALARM, SEN_LAST_CALIBRATE, SEN_CALIBRATE_PERIOD) 
				VALUES ('.implode(', ', $this->key_SENSOR).');');
		$this->prep_VARIOUS = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO `TA_VARIOUS` 
					(`VAR_DATE`, `VAR_SAMPLE_RAINFALL`, `VAR_SAMPLE_RAINFALL_HIGHT`, `VAR_PRESSURE_ALT0`, `VAR_SOLAR_RADIATION`, `VAR_SOLAR_RADIATION_HIGHT`, `VAR_WIND_SPEED`, `VAR_WIND_SPEED_HIGHT`, `VAR_WIND_SPEED_HIGHT_DIR`, `VAR_WIND_SPEED_DOMINANT_DIR`, `VAR_UV_INDEX`, `VAR_UV_INDEX_HIGHT`, `VAR_FORECAST_RULE`, `VAR_ET`)
				VALUES ('.implode(', ', $this->key_VARIOUS).');');
// 		$this->T_12H = 'SELECT (AVG(  `VALUE` ) -32) *5 /9 AS AVG_TEMP_IN_CELSIUS FROM `TA_TEMPERATURE` 
// 				INNER JOIN `TA_VARIOUS` ON `ID` = `VAR_ID` 
// 				WHERE `VAR_DATE` >= :SINCE AND `SEN_ID` =:SENSOR_ID ;';
	}
	public function initConnection()	{
		$errno = 0;
		$this->fp = @fsockopen (
			$this->conf['_ip'],
			$this->conf['_port']
		);
		if ($this->fp && $errno==0) {
			stream_set_timeout ($this->fp, 0, 2500000);
			if ($this->wakeUp()) {
				$this->toggleBacklight (1);
				log_message('wswds', _( sprintf('Ouverture de la connexion à %s', $this->conf['_name']) ) );
				return TRUE;
			}
			else {
				fclose($this->fp);
			}
		}
		return FALSE;
	}
	function CloseConnection()	{
		$this->toggleBacklight(0);
		if (fclose($this->fp)) {
			log_message('wswds', sprintf( _('Fermeture de %s correcte.'), $this->conf['_name'] ) );
			return TRUE;
		}
		return FALSE;
	}
	/**
	@description: compare l'heure de la station a celle du serveur web et lance la synchro si besoin
	@return: renvoi TRUE si deja a l'heure , renvoi l'heure en cas de Synchro reuci et FALSE en cas d'echec
	@param: maxLag est la valeur maxi toleré pour le decalage, force==TRUE ignorera le decalage et force l'heure serveur'.
	*/
	function clockSync($maxLag, $force=false) {
		$TIME = False;
		$realLag = abs(strtotime($this->fetchStationTime()) - strtotime(date('Y/m/d H:i:s')));
		log_message('Step',  __FUNCTION__.'('.__CLASS__.")\n".__FILE__.' ['.__LINE__.']');
		if ($realLag > $maxLag || $force) {
			Waiting( 0, sprintf( _('Default Clock synchronize : %ssec'), $realLag) );
			if ($realLag < 3600-$maxLag || $realLag > 3600*12 || $force) {	// OK
				if ($TIME = $this->updateStationTime()) {							// OK
					log_message('wswds', _('Clock synchronizing.'));					// OK
				}
				else log_message('warning', _( 'Clock synch.'));
			}
			else log_message('warning', sprintf( _('So mutch Default : %ssec. Please change it manualy'), $realLag) );
		}
		else return true;
		log_message('Step',  __FUNCTION__.'('.__CLASS__.")\n".__FILE__.' ['.__LINE__.']');
		return $TIME;
	}
	protected function wakeUp()	{
		for ($i=0;$i<=3;$i++) {
			@fwrite ($this->fp, LF);
			if (fread($this->fp,6)==LFCR)
				return TRUE;
			usleep(1200000);
		}
		return FALSE;
	}
	protected function toggleBacklight($force=-1) {
		if ($force==-1) {
			fwrite ($this->fp,'LAMPS '.(($this->backLightScreen)?'0':'1').LF);
		}
		else {
			fwrite ($this->fp,'LAMPS '.($force?'1':'0').LF);
		}
		if (fread($this->fp,6)==OK) {
			if ($force==-1) {
				$this->backLightScreen = !$this->backLightScreen;
			}
			else {
				$this->backLightScreen = $force;
			}
			usleep(500000);
			return TRUE;
		}
		return FALSE;
	}
	/**
	@description: functionDescription
	@return: functionReturn
	@param: returnValue
	*/
	function VerifAnswersAndCRC($data, $len) {
		if (strlen($data)!=$len){
			throw new Exception(sprintf(_('Incomplete Data strlen = %d insted of : %d'),strlen($data),$len));
		}
		
		$crc = CalculateCRC($data);
		if ($crc != DBL_NULL /* chr(0).(0) "\x00\x00" */ ){
			throw new Exception(sprintf(_('Wrong CRC, on good data : crc=0x%X 0x%X , strlen=%d'),
											$crc[0], $crc[1],
												strlen($data)));
		}
		return true;
	}
	/**
	@description: functionDescription
	@return: functionReturn
	@param: returnValue
	*/
	function RequestCmd($cmd) { //
		fwrite ($this->fp, $cmd);
		$r = fread($this->fp, 1);
		if ($r == ACK){
			return true;
		}
		else if ($r == NAK)
		{
			throw new Exception(sprintf(_('Command [%s] not understand'),$cmd));
		}
		else {
			throw new Exception(_('Unknow Error, Reconnection'));
		}
	}
	/**
	@description: functionDescription
	@return: functionReturn
	@param: returnValue
	*/
	function subRaw($RawStr, $val) {
		if (is_int($val['pos'])) {
			// si la donnée est sur un nombre entier d'octés de la chaine RAW
			return substr ($RawStr, $val['pos'], $val['len']);
		}
		else {	// dans le cas ou la donnée n'est que sur quelques bits
			return getBits(
				hexToDec(substr ($RawStr, (int)$val['pos'],1)),
				((($val['pos']*10)-((int)$val['pos'])*10)-1),
				$val['len']);
		}
	}
	function convertRaw($StrValue, $limits) {
	// Retourne la chaine binaire sous la forme Numerique dans l'unité de la VP2
	// retourne NULL si le capteur retourne la valeur d'erreur
		if (is_callable($limits['fn'])) {
			$val = $limits['fn']($StrValue);
			if ($val == $limits['err'])
				return NULL;
			return $val;
		}
		return 'No function to convert !';
	}
	function convertUnit($Value, $limits) {
	// Retourne la valeur numerique coverti en unité SI
	// Retourne FALSE si la valeur est incohérante.
		if (is_callable($limits['SI']) and !is_string($Value)) {
			$val = $limits['SI']($Value);
			if ($val >= $limits['max'] or $val <= $limits['min'])
				return FALSE;
			return $val;
		}
		return $Value;
	}
	function RawConverter($DataModele, $RawStr) { //
		$data = array();
		foreach($DataModele as $key=>$limits)
			$data[$key] = $this->convertUnit( $this->convertRaw( $this->subRaw( $RawStr, $limits), $limits), $limits);
			print_r($data);
		return $data;
	}
	/**
	@description: Lis les config courante disponible sur la station
	@return: retourne un tableau de la forme :
		array ('Date Heure' => array ( Conf1, Conf2, ... ));
	@param: none
	*/
	function GetConfig() { //
		$CONFS = false;
		 try {
			log_message('wswds', '[EEBRD] : Download the current Config');
			
// 			$P=str_pad(strtoupper(dechex(0)),3,'0',STR_PAD_LEFT);
// 			$L=str_pad(strtoupper(dechex(177)),2,'0',STR_PAD_LEFT);
			$this->RequestCmd("EEBRD 000 B1\n");
			$data = fread($this->fp, 177+2);
			$this->VerifAnswersAndCRC($data, 177+2);
			
// 			$P=str_pad(strtoupper(dechex(4092)),3,'0',STR_PAD_LEFT);
// 			$L=str_pad(strtoupper(dechex(1)),2,'0',STR_PAD_LEFT);
			$this->RequestCmd("EEBRD FFC 01\n");
			$data2 = fread($this->fp, 1+2);
			$this->VerifAnswersAndCRC($data2, 1+2);
				$v = end($this->EEPROM);
				$v['pos'] = 1;
				$k = key($this->EEPROM);
			$CONFS[date('Y/m/d H:i:s')] = array_merge (
				$this->RawConverter($this->EEPROM, $data),
				$this->RawConverter(array($k => $v), $data2));
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
			return false;
		}
		return $CONFS;
	}
	/**
	@description: Lis les valeur courante de tous les capteur disponible sur la station
	@return: retourne un tableau de tableau de la forme :
		array (
			'Date Heure_0' => array ( Data1, Data2, ... ),
			'Date Heure_0 + 2.5sec ' => array ( Data1, Data2, ... ),
			... );
	@param: Nombre de cycle CURRENT a relever (Par defaut 1 seul).
	*/
	function GetLoop ($nbr=1) {
		$_NBR = $nbr;
		$LOOPS = false;
		try {
			$this->RequestCmd("LOOP $nbr\n");
			while ($nbr-- > 0) {
				$data = fread($this->fp, 99);
				$this->VerifAnswersAndCRC($data, 99);
				log_message('wswds', '[LOOP] : Download the current Values');
				$LOOPS[date('Y/m/d H:i:s')] = $this->RawConverter($this->Loop, $data);
				echo implode("\t",$LOOPS[0])."\n";
			}
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
		return $LOOPS;
	}
	/**
	@description: Lis les valeur d´archive a partir d´une date
	@return: retourne un tableau de la forme :
		array (
			'Date Heure_0' => array ( Arch1, Arch2, ... ),
			'Date Heure_1' => array ( Arch1, Arch2, ... ),
			... );
	@param: Date de la 1ere archive a lire (par defaut : 2012/01/01 00:00:00)
	*/
	function GetDmpAft($last, $save=true) { //
		$DATAS=false;
		try {
			$firstDate2Get=is_date($last);
			$this->RequestCmd("DMPAFT\n");
			$RawDate = DMPAFT_SetVP2Date($firstDate2Get);
			fwrite($this->fp, $RawDate);				// Send this date (parametre #1)
			$crc = CalculateCRC($RawDate);			// define the CRC of my date
			$this->RequestCmd($crc);					// Send the CRC (parametre #2)
			$data = fread($this->fp, 6);				// we read the properties : item count and first item position
			$this->VerifAnswersAndCRC($data, 6);
// 			$nbrArch=0;
			$LastArchDate = 0;
// 			$retry = $this->retry-1;
			$nbrPages = hexToDec (strrev(substr($data,0,2)));	// Split Bytes in revers order : Nbr of page
			$firstArch = hexToDec (strrev(substr($data,2,2)));	// Split Bytes in revers order : # of first archived
				log_message('wswds', 'There are '.$nbrPages.'p. in queue, from archive '.$firstArch.' on first page since '.$last.'.');
			fwrite($this->fp, ACK);				// Send ACK to start
			for ($j=0; $j<$nbrPages; $j++) {
				if ( !((time()+10)%300) ) {
				// la recuperation des archives bloque la lecture des capteurs donc on le fait par petit bout
					throw new Exception(_('Please retry later to finish, Data sensors must be checked in few second.'));
				}
				$Page = fread($this->fp, 267);
				log_message('dl', 'Archive PAGE #'.$j.' since : '.DMPAFT_GetVP2Date(substr($Page,1+52*($firstArch),4)));
				$this->VerifAnswersAndCRC($Page, 267);
				fwrite ($this->fp, ACK);
				for ($k=$firstArch; $k<=4; $k++) {			// ignore les 1er valeur hors champ.
					$ArchiveStrRaw = substr ($Page, 1+52*$k, 52);
					$ArchDate = DMPAFT_GetVP2Date(substr($ArchiveStrRaw,0,4));
					if (strtotime($ArchDate) > strtotime($LastArchDate)) {
					// ignore les derniere valeur hors champ, car on parcoure une liste circulaire
					// donc la deniere valeur a extraire precede la plus vielle valleur de cette liste
						$DATAS = $this->RawConverter($this->DumpAfter, $ArchiveStrRaw);
						if ($save) {
							$this->save_Archive($DATAS);
							log_message('save', sprintf(_('Page #%d-%d of %s archived Ok.'),$j, $k, $ArchDate));
						}
						$LastArchDate = $ArchDate;
					}
					else {
						throw new Exception(sprintf(_('Page #%d-%d of %s Ignored (Out of Range).'),$j, $k, $ArchDate));
					}
					$firstArch=0;
				}
			}
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
			return true;
		}
		return false;
	}
	/**
	@description: Lis l'heure de la station
	@return: retourne l'heure de la station ou FALSE en cas d'echec
	@param: none
	*/
	function fetchStationTime() {// 0x35 16 00 1d 0c 6f  0x7c 44  ==  2011/12/29 00:22:53
		$TIME = False;
		try {
			$this->RequestCmd("GETTIME\n");
			$TIME = fread($this->fp, 8);
			$this->VerifAnswersAndCRC($TIME, 8);
			$TIME = (ord($TIME[5])+1900)
				.'/'.str_pad(ord($TIME[4]),2,'0',STR_PAD_LEFT)
				.'/'.str_pad(ord($TIME[3]),2,'0',STR_PAD_LEFT)
				.' '.str_pad(ord($TIME[2]),2,'0',STR_PAD_LEFT)
				.':'.str_pad(ord($TIME[1]),2,'0',STR_PAD_LEFT)
				.':'.str_pad(ord($TIME[0]),2,'0',STR_PAD_LEFT);
			log_message('wswds',  'Real : '.date('Y/m/d H:i:s').' vs VP2 : '.$TIME);
			return $TIME;
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
		return $TIME;
	}
	/**
	@description: Force l´heure de la station a la meme heure que le serveur web
	@return: renvoi la nouvelle heure ou FALSE en cas d'echec
	@param: none
	*/
	function updateStationTime() {// 0x35 16 00 1d 0c 6f  0x7c 44  ==  2011/12/29 00:22:53
		try {
			$this->RequestCmd("SETTIME\n");
			list($_date, $_clock) = explode(' ', date('Y/m/d H:i:s'));
			list($y,$m,$d) = explode('/', $_date);
			list($h,$i,$s) = explode(':', $_clock);
			$TIME = chr($s).chr($i).chr($h).chr($d).chr($m).chr($y-1900);
			$this->RequestCmd ($TIME . CalculateCRC($TIME));
			log_message('wswds', '[SETTIME] : '.$_date.' '.$_clock);
			return $_date.' '.$_clock;
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
		return False;
	}
	function save_Archive($data){
		$this->current_data = $data;
		$this->insert_VARIOUS(array(
			$data['TA:Arch:Various:Time:UTC'], 
			$data['TA:Arch:Rain:RainFall:Sample'], 
			$data['TA:Arch:Rain:RainRate:HighSample'], 
			$data['TA:Arch:Various:Bar:Current'], 
			$data['TA:Arch:Various:Solar:Radiation'], 
			
			$data['TA:Arch:Various:Solar:HighRadiation'], 
			$data['TA:Arch:Various:Wind:SpeedAvg'], 
			$data['TA:Arch:Various:Wind:HighSpeed'], 
			$data['TA:Arch:Various:Wind:HighSpeedDirection'], 
			$data['TA:Arch:Various:Wind:DominantDirection'], 
			
			$data['TA:Arch:Various:UV:IndexAvg'], 
			$data['TA:Arch:Various:UV:HighIndex'], 
			$data['TA:Arch:Various::ForecastRule'],
			$data['TA:Arch:Various:ET:Hour']
			));
		$id_arch = $this->dataDB->insert_id(); // query('SELECT LAST_INSERT_ID();');

		foreach ($data as $name => $val) {
			if ($val !== NULL && $val !== FALSE) {
				$table = $this->get_TABLE_Dest($name);
				$Sensor = $this->get_SEN_ID($name,$table);
				if ($table != 'TA_VARIOUS') {
					$eav = 'prep_EAV_'.$table[3];
					$this->$eav->execute(array_combine($this->key_EAV, array($id_arch, $val, $Sensor['SENSOR_ID'])));
				}
			}
		}
	}
	function insert_SENSOR($value_SENSOR) {
		$real_SENSOR = array_combine($this->key_SENSOR, $value_SENSOR);
// 		log_message('save', 'real_SENSOR');
		$this->prep_SENSOR->execute($real_SENSOR);
	}
	function insert_VARIOUS($value_VARIOUS) {
		$real_VARIOUS = array_combine($this->key_VARIOUS, $value_VARIOUS);
// 		log_message('save', 'real_VARIOUS');
// 		print_r($real_VARIOUS);
// 		echo $this->prep_VARIOUS->queryString;
// 		log_message('sql', 'insert_VARIOUS');
		$this->prep_VARIOUS->execute($real_VARIOUS);
	}
	function get_TABLE_Dest($name) {
		if (strpos($name, ':Temp:') !== false)
			return 'TA_TEMPERATURE';
		elseif (strpos($name, ':Hum:') !== false)
			return 'TA_HUMIDITY';
		elseif (strpos($name, ':LeafWetnesses:') !== false)
			return 'TA_WETNESSES';
		elseif (strpos($name, ':SoilMoisture:') !== false)
			return 'TA_MOISTURE';
		else
			return 'TA_VARIOUS';
	}
	function get_SEN_ID($name, $table, $recursive = true) {
		$min = array('TA_TEMPERATURE'=>-50,'TA_HUMIDITY'=>0,'TA_WETNESSES'=>0,'TA_MOISTURE'=>0,'TA_VARIOUS'=>0);
		$max = array('TA_TEMPERATURE'=>80,'TA_HUMIDITY'=>100,'TA_WETNESSES'=>100,'TA_MOISTURE'=>100,'TA_VARIOUS'=>65000);
		$id = $this->dataDB->query('SELECT SEN_ID AS SENSOR_ID, SEN_MIN_REALISTIC AS MIN, SEN_MAX_REALISTIC AS MAX FROM `TR_SENSOR` WHERE SEN_NAME=\''.$name.'\' ;');
		if (count($id->result_array())==1) {
			return $id->result_array[0];
		}
		else if (count($id->result_array())==0 and $recursive==TRUE) { // $id->num_rows();
			$this->insert_SENSOR(array($name, 'HUMAN NAME is more than '.$name, 'DESCRIPT', $min[$table], $max[$table], 'unkow', 'standard', 32000, 0, date ("Y/m/d H:i:s"), 'P0Y6M0DT0H0M0S'));
/*			$this->dataDB->query('INSERT 
				INTO `TR_SENSOR` 
					(SEN_NAME, SEN_DEF_PLOT, SEN_MAX_ALARM, SEN_MIN_ALARM, SEN_LAST_CALIBRATE, SEN_CALIBRATE_PERIOD) 
				VALUES 
					(\''.$name.'\', \'Default_Plot\', 1999, -199, \'2012/01/01 00:00:01\', \'0000/06/00 00:00:00\')');*/
			return $this->get_SEN_ID($name, false); // dataDB->insert_id(); // query('SELECT LAST_INSERT_ID();');
		}
		print_r($id->result_array);
		log_message('warning', 'Resultat inutilisable ('.$name.')');
	}
	
	function get_Last_Date() {
		$date = $this->dataDB->query('SELECT MAX(VAR_DATE) as LAST_ARCH_DATETIME FROM `TA_VARIOUS`;');
		if (count($date->result_array())==1) {
			return $date->result_array[0]['LAST_ARCH_DATETIME'];
		}
		log_message('warning', 'Resultat inutilisable : '.print_r($date));
		return '2012/01/01 00:00:00';
	}
}