<?php // clear;php5 -f /var/www/WsWds/cli.php 'cron'
class vp2 extends CI_Model {
	protected $fp=NULL;	// Pointer of VP2 Connection
	protected $backLightScreen=FALSE; // actual state of backlight screen
	public $_version = 0.23;
	protected $conf = null;
	
	protected $prep_EAV = NULL;
	protected $key_EAV = array(':id', ':val', ':sensorID');

	protected $prep_SENSOR = NULL;
	protected $key_SENSOR = array(':ID', ':NAME', ':HUMAN_NAME', ':DESCRIPT', ':MIN_REAL', ':MAX_REAL', ':UNITE_SIGN', ':DEF_PLOT', ':MAX_ALARM', ':MIN_ALARM', ':LAST_CALIBRATE', ':CALIBRATE_PERIOD');

	protected $prep_VARIOUS = NULL;
	protected $key_VARIOUS = array(':UTC_date', ':rainfall', ':max_rainfall', ':pressure', ':srad', ':max_srad', ':wspeed', ':max_wspeed', ':dir_higtspeed', ':dir_dominant', ':uv', ':max_uv', ':forecast', ':et');
	
	protected $dataDB = NULL;
	protected $current_data = NULL;
	
	function __construct($conf)
	{
		parent::__construct();
		log_message('init',  __FUNCTION__.'('.__CLASS__.' ('.$conf['name'].':'.($base = $conf['db']).') '.")\n".__FILE__.' ['.__LINE__.']');
		$this->conf = $conf;
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
					(SEN_ID, SEN_NAME, SEN_HUMAN_NAME, SEN_DESCRIPTIF, SEN_MIN_REALISTIC, SEN_MAX_REALISTIC, SEN_UNITE_SIGN, SEN_DEF_PLOT, SEN_MAX_ALARM, SEN_MIN_ALARM, SEN_LAST_CALIBRATE, SEN_CALIBRATE_PERIOD) 
				VALUES ('.implode(', ', $this->key_SENSOR).');');
		$this->prep_VARIOUS = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO `TA_VARIOUS` 
					(`VAR_DATE`, `VAR_SAMPLE_RAINFALL`, `VAR_SAMPLE_RAINFALL_HIGHT`, `VAR_PRESSURE`, `VAR_SOLAR_RADIATION`, `VAR_SOLAR_RADIATION_HIGHT`, `VAR_WIND_SPEED`, `VAR_WIND_SPEED_HIGHT`, `VAR_WIND_SPEED_HIGHT_DIR`, `VAR_WIND_SPEED_DOMINANT_DIR`, `VAR_UV_INDEX`, `VAR_UV_INDEX_HIGHT`, `VAR_FORECAST_RULE`, `VAR_ET`)
				VALUES ('.implode(', ', $this->key_VARIOUS).');');
	}
	
	public function initConnection()	{
		$errno = 0;
		$this->fp = @fsockopen (
			$this->conf['ip'],
			$this->conf['port']
		);
		if ($this->fp && $errno==0) {
			stream_set_timeout ($this->fp, 0, 2500000);
			if ($this->wakeUp()) {
				$this->toggleBacklight (1);
				log_message('wswds', _( sprintf('Ouverture de la connexion à %s', $this->conf['name']) ) );
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
			log_message('wswds', sprintf( _('Fermeture de %s correcte.'), $this->conf['name'] ) );
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
	function RawConverter($DataModele, $RawStr) { //
		$x = array();
		foreach($DataModele as $key=>$val) {
			if (is_int($val['pos'])) {
				$StrValue = substr ($RawStr, $val['pos'], $val['len']);
			}
			else {
				$StrValue = getBits(
					substr ($RawStr, (int)$val['pos'],1),
					($val['pos']-(int)$val['pos']-0.1)*10,
					$val['len']);
			}

			if ($val['fn']) {
				$x[$key] = call_user_func($val['fn'], $StrValue);
				
// I benchmarked the comparison in speed between variable functions, call_user_func, and eval.  My results are below:
// 
// Variable functions took 0.125958204269 seconds.
// call_user_func took 0.485446929932 seconds.
// eval took 2.78526711464 seconds.
// 
// This was run on a Compaq Proliant server, 180MHz Pentium Pro 256MB RAM.  Code is as follows:
// 
// <?php
// 
// function fa () { return 1; }
// function fb () { return 1; }
// function fc () { return 1; }
// 
// $calla = 'fa';
// $callb = 'fb';
// $callc = 'fc';
// 
// $time = microtime( true );
// for( $i = 5000; $i--; ) {
//     $x = 0;
//     $x += $calla();
//     $x += $callb();
//     $x += $callc();
//     if( $x != 3 ) die( 'Bad numbers' );
// }
// echo( "Variable functions took " . (microtime( true ) - $time) . " seconds.<br />" );
// 
// $time = microtime( true );
// for( $i = 5000; $i--; ) {
//     $x = 0;
//     $x += call_user_func('fa', '');
//     $x += call_user_func('fb', '');
//     $x += call_user_func('fc', '');
//     if( $x != 3 ) die( 'Bad numbers' );
// }
// echo( "call_user_func took " . (microtime( true ) - $time) . " seconds.<br />" );
// 
// $time = microtime( true );
// for( $i = 5000; $i--; ) {
//     $x = 0;
//     eval( '$x += ' . $calla . '();' );
//     eval( '$x += ' . $callb . '();' );
//     eval( '$x += ' . $callc . '();' );
//     if( $x != 3 ) die( 'Bad numbers' );
// }
// echo( "eval took " . (microtime( true ) - $time) . " seconds.<br />" );
// 
// ? >
				
			}
			else {
				$x[$key] = $StrValue;
			}
		}
		return $x;
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
			self::RequestCmd("EEBRD 000 B1\n");
			$data = fread($this->fp, 177+2);
			self::VerifAnswersAndCRC($data, 177+2);
			
// 			$P=str_pad(strtoupper(dechex(4092)),3,'0',STR_PAD_LEFT);
// 			$L=str_pad(strtoupper(dechex(1)),2,'0',STR_PAD_LEFT);
			self::RequestCmd("EEBRD FFC 01\n");
			$data2 = fread($this->fp, 1+2);
			self::VerifAnswersAndCRC($data2, 1+2);
				$v = end($this->EEPROM);
				$v['pos'] = 1;
				$k = key($this->EEPROM);
			$CONFS[date('Y/m/d H:i:s')] = array_merge (
				self::RawConverter($this->EEPROM, $data),
				self::RawConverter(array($k => $v), $data2));
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
			self::RequestCmd("LOOP $nbr\n");
			while ($nbr-- > 0) {
				$data = fread($this->fp, 99);
				self::VerifAnswersAndCRC($data, 99);
				log_message('wswds', '[LOOP] : Download the current Values');
				$LOOPS[date('Y/m/d H:i:s')] = self::RawConverter($this->Loop, $data);
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
			self::RequestCmd("DMPAFT\n");
			$RawDate = DMPAFT_SetVP2Date($firstDate2Get);
			fwrite($this->fp, $RawDate);				// Send this date (parametre #1)
			$crc = CalculateCRC($RawDate);			// define the CRC of my date
			self::RequestCmd($crc);					// Send the CRC (parametre #2)
			$data = fread($this->fp, 6);				// we read the properties : item count and first item position
			self::VerifAnswersAndCRC($data, 6);
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
				self::VerifAnswersAndCRC($Page, 267);
				fwrite ($this->fp, ACK);
				for ($k=$firstArch; $k<=4; $k++) {			// ignore les 1er valeur hors champ.
					$ArchiveStrRaw = substr ($Page, 1+52*$k, 52);
					$ArchDate = DMPAFT_GetVP2Date(substr($ArchiveStrRaw,0,4));
					if (strtotime($ArchDate) > strtotime($LastArchDate)) {
					// ignore les derniere valeur hors champ, car on parcoure une liste circulaire
					// donc la deniere valeur a extraire precede la plus vielle valleur de cette liste
						$DATAS[$ArchDate] = self::RawConverter($this->DumpAfter, $ArchiveStrRaw);
						log_message('dl', sprintf(_('Page #%d-%d of %s archived Ok.'),$j, $k, $ArchDate));
						if ($save) {
							$this->save_Archive($DATAS[$ArchDate]);
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
		}
		return $DATAS;
	}
	/**
	@description: Lis l'heure de la station
	@return: retourne l'heure de la station ou FALSE en cas d'echec
	@param: none
	*/
	function fetchStationTime() {// 0x35 16 00 1d 0c 6f  0x7c 44  ==  2011/12/29 00:22:53
		$TIME = False;
		try {
			self::RequestCmd("GETTIME\n");
			$TIME = fread($this->fp, 8);
			self::VerifAnswersAndCRC($TIME, 8);
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
			self::RequestCmd("SETTIME\n");
			list($_date, $_clock) = explode(' ', date('Y/m/d H:i:s'));
			list($y,$m,$d) = explode('/', $_date);
			list($h,$i,$s) = explode(':', $_clock);
			self::RequestCmd (chr($s).chr($i).chr($h).chr($d).chr($m).chr($y-1900) . CalculateCRC($TIME));
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
		$id_arch = $this->dataDB->insert_id();//query('SELECT LAST_INSERT_ID();');
		foreach ($data as $name => $val) {
			if (($table = $this->get_TABLE_Dest($name)) != 'TA_VARIOUS') {
				$eav = 'prep_EAV_'.$table[3];
				$this->$eav->execute(array_combine($this->key_EAV, array($id_arch, $val, $this->get_SEN_ID($name))));
			}
		}
	}

	function insert_SENSOR($value_SENSOR) {
		$real_SENSOR = array_combine($this->key_SENSOR, $value_SENSOR);
		$this->prep_SENSOR->execute($real_SENSOR);
	}
	function insert_VARIOUS($value_VARIOUS) {
		$real_VARIOUS = array_combine($this->key_VARIOUS, $value_VARIOUS);
// 		print_r($real_VARIOUS);
// 		echo $this->prep_VARIOUS->queryString;
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
	function get_SEN_ID($name) {
		$id = $this->dataDB->query('SELECT SEN_ID FROM `TR_SENSOR` WHERE SEN_NAME=\''.$name.'\' LIMIT 3');
		if (count($id->result_array())==1) {
			return end($id->result_array[0]);
		}
		else if (count($id->result_array())==0) {
			$this->dataDB->query('INSERT 
				INTO `TR_SENSOR` 
					(SEN_NAME, SEN_DEF_PLOT, SEN_MAX_ALARM, SEN_MIN_ALARM, SEN_LAST_CALIBRATE, SEN_CALIBRATE_PERIOD) 
				VALUES 
					(\''.$name.'\', \'Default_Plot\', 1999, -199, \'2012/01/01 00:00:01\', \'0000/06/00 00:00:00\')');
			return $this->dataDB->insert_id();//query('SELECT LAST_INSERT_ID();');
		}
		log_message('warning', 'Trop de resultat : '.print_r($id));
	}
	
	function get_Last_Date() {
		$date = $this->dataDB->query('SELECT MAX(VAR_DATE) FROM `TA_VARIOUS` LIMIT 3');
		if (count($date->result_array())==1) {
			return end($date->result_array[0]);
		}
		else if (count($date->result_array())==0) {
			return '2012/01/01 00:00:00';
		}
		log_message('warning', 'Trop de resultat : '.print_r($date));
	}
}