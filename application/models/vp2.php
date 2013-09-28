<?php // clear;php5 -f /var/www/Probe/cli.php 'cron'
class vp2 extends CI_Model {

/**

	* @param
	* @var 
	*/
	protected $fp=NULL;	// Pointer of VP2 Connection
	protected $backLightScreen=FALSE; // actual state of backlight screen
	public $_version = 0.31;
	protected $conf = null;
	protected $lockFile;
	
	protected $prep_EAV = NULL;
	protected $key_EAV = array(':utc', ':val', ':sensorID');

	protected $prep_SENSOR = NULL;
	protected $key_SENSOR = array(':NAME', ':HUMAN_NAME', ':DESCRIPT', ':MIN_REAL', ':MAX_REAL', ':ENGINE_UNIT', ':USER_UNIT', ':DEF_PLOT', ':MAX_ALARM', ':MIN_ALARM', ':LAST_CALIBRATE', ':CALIBRATE_PERIOD');

	protected $prep_VARIOUS = NULL;
	
	protected $dataDB = NULL;
	protected $current_data = NULL;
	protected $OffsetTime = NULL;
	

/**

	* @param
	* @var 
	* @return 
	*/
	function __construct($conf)
	{
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__);
		parent::__construct();
		$this->conf = $conf;
		// $this->OffsetTime = $this->OffsetTime();

		require (APPPATH.'models/vp2/EepromDumpAfter.h.php');
		require (APPPATH.'models/vp2/EepromLoop.h.php');
		require (APPPATH.'models/vp2/EepromLoop2.h.php');
		require (APPPATH.'models/vp2/EepromHiLow.h.php');
		require (APPPATH.'models/vp2/EepromConfig.h.php');

		$this->dataDB = $this->load->database($conf, TRUE);

		$this->prep_EAV_T = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO TA_TEMPERATURE (UTC, VALUE, SEN_ID) 
				VALUES (:utc, :val, :sensorID);');
		$this->prep_EAV_H = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO TA_HUMIDITY (UTC, VALUE, SEN_ID) 
				VALUES (:utc, :val, :sensorID);');
		$this->prep_EAV_W = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO TA_WETNESSES (UTC, VALUE, SEN_ID) 
				VALUES (:utc, :val, :sensorID);');
		$this->prep_EAV_M = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO TA_MOISTURE (UTC, VALUE, SEN_ID) 
				VALUES (:utc, :val, :sensorID);');
		$this->prep_EAV_V = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO TA_VARIOUS (UTC, VALUE, SEN_ID) 
				VALUES (:utc, :val, :sensorID);');
		$this->prep_SENSOR = $this->dataDB->conn_id->prepare(
			'REPLACE 
				INTO `TR_SENSOR` 
					(SEN_NAME, SEN_HUMAN_NAME, SEN_DESCRIPTIF, SEN_MIN_REALISTIC, SEN_MAX_REALISTIC, SEN_ENGINE_UNIT, SEN_USER_UNIT, SEN_DEF_PLOT, SEN_MAX_ALARM, SEN_MIN_ALARM, SEN_LAST_CALIBRATE, SEN_CALIBRATE_PERIOD) 
				VALUES ('.implode(', ', $this->key_SENSOR).');');
	}

/**

	* @param
	* @var 
	* @return 
	*/
	function chekpolitness () {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->conf['_name']));
		$this->lockFile = dirname(__FILE__).'/'.$this->conf['_name'].'.lock';
		$end = @file_get_contents($this->lockFile);

		if ($end===FALSE // impossible de lire le contenu
			|| strtotime(date ("Y/m/d H:i:s")) > strtotime($end) + 60 * 5) // lock agé de plus de 5min
		{
			file_put_contents($this->lockFile, date ("Y/m/d H:i:s"));
			return true;
		}
		log_message('infos', sprintf(
            i18n('cli-warning.available-connexion[%s]:fail.label'), $this->conf['_name'] ) );
		return FALSE;
	}

/**

	* @param
	* @var 
	* @return 
	*/
	function initConnection()	{
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->conf['_name']));
		if ($this->chekpolitness()) {
			$errno = 0;
			$this->fp = @fsockopen (
				$this->conf['_ip'],
				$this->conf['_port']
			);
			if ($this->fp && $errno==0) {
				stream_set_timeout ($this->fp, 0, 2500000);
				if ($this->wakeUp()) {
					// 	$this->toggleBacklight (1);
					log_message('infos', sprintf(
                        i18n('cli-info.open-connexion[%s].label'), $this->conf['_name']
                    ) );
					return TRUE;
				}
				else {
					fclose($this->fp);
				}
			}
		}
		if (!unlink($this->lockFile))
			rename($this->lockFile, ".trash");
		return FALSE;
	}

/**

	* @param
	* @var 
	* @return 
	*/
	function CloseConnection()	{
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->conf['_name']));
		// $this->toggleBacklight(0);
		if (!unlink($this->lockFile))
			rename($this->lockFile, ".trash");
		if (fclose($this->fp)) {
			log_message('infos', sprintf(
			    i18n('cli-info.close-connexion[%s]:success.label'),
			        $this->conf['_name']
			) );
            return true;
		}
		return FALSE;
	}

/**

	* @param
	* @var 
	* @return 
	*/
	function wakeUp()	{
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->conf['_name']));
		for ($i=0;$i<=3;$i++) {
			@fwrite ($this->fp, LF);
			if (fread($this->fp,6)==LFCR) {
				return TRUE;
			}
			usleep(1200000);
		}
		return FALSE;
	}

/**

	* @param
	* @var 
	* @return 
	*/
	function toggleBacklight($force=-1) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
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

	* @description: protected functionDescription
	* @return: protected functionReturn
	* @param: returnValue
	*/
	protected function VerifAnswersAndCRC($data, $len) {
		if (strlen($data)!=$len){
			throw new Exception(sprintf(
                i18n('cli-error.transmission[%d]:incomplete[%d].label'),
                strlen($data), $len
            ));
		}
		
		$crc = CalculateCRC($data);
		if ($crc != DBL_NULL /* chr(0).(0) "\x00\x00" */ ){
			throw new Exception(sprintf(
                i18n('cli-error.checksum[%X%X]:fail[%d].label'),
                $crc[0], $crc[1], strlen($data)
            ));
		}
		return true;
	}
/**
	* @return: protected functionReturn
	* @param: returnValue
	*/
	protected function RequestCmd($cmd) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->conf['_name'], $cmd));
		fwrite ($this->fp, $cmd);
		$r = fread($this->fp, 1);
		if ($r == ACK){
			return true;
		}
		else if ($r == NAK)
		{
			throw new Exception(sprintf(
                i18n('cli-error.command[%s]:fail.label'),
                $cmd
            ));
		}
		else {
			throw new Exception(sprintf(
                i18n('cli-error.command[%s]:exception.label'),
                $cmd
            ));
		}
	}


/**
Lis les config courante disponible sur la station
	* @return: retourne un tableau de la forme :
	*	array ('Date Heure' => array ( Conf1, Conf2, ... ));
	* @param: none
	*/
	function GetConfig() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($this->conf['_name']));
		$CONFS = false;
		 try {
			log_message('infos', '[EEBRD] : Download the current Config');
			
			$this->RequestCmd("EEBRD 000 B1\n");
			$data = fread($this->fp, 177+2);
			$this->VerifAnswersAndCRC($data, 177+2);

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
			return array();
		}

		return $CONFS;
	}

/**

	* @param
	* @var 
	* @return 
	*/
	function GetHiLows() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$HILOW = false;
		try {
			log_message('infos', '[EEBRD] : Download the current Config');
			
			$this->RequestCmd("HILOWS\n");
			$data = fread($this->fp, 436+2);
			log_message('infos', '[HILOWS] : Download the current Values');
			$this->VerifAnswersAndCRC($data, 436+2);
			saveDataOnFile(
				'data/'.$this->conf['_name'].'/HILOWS'/*.'-'.date('Y/m/d H:i:s')*/,
				array_merge( array('UTC_date'=>date('Y/m/d H:i:s')), $HILOWS = $this->RawConverter($this->HiLows, $data)),
				FORMAT_JSON + FORMAT_PHP);		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
			return false;
		}

		return $HILOWS;
	}
/**
Lis les valeurs courantes de tous les capteurs disponible sur la station
	* @return: retourne un tableau de tableau de la forme :
	*	array (
	*		'Date Heure_0' => array ( Data1, Data2, ... ),
	*		'Date Heure_0 + 2.5sec ' => array ( Data1, Data2, ... ),
	*		... );
	* @param: Type de donnee attendu voir Doc LOOP et LOOP2.
	* @param: Nombre de cycle CURRENT a relever (Par defaut 1 seul).
	*/
	function GetLPS ($type=0x03, $nbr=2) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$LPS = array();
		try {
			$this->RequestCmd("LPS $type $nbr\n");
			while ($nbr > 0) {
				$data = fread($this->fp, 97+2);
				$this->VerifAnswersAndCRC($data, 97+2);
				$packet_type = current($this->RawConverter(array('LPS0:Data:Packet:Type'=>$this->Loop['LPS0:Data:Packet:Type:::']), $data));
				log_message('infos', '[LPS] : Download the current Values LOOP'.($packet_type?'':'2'));
				switch($packet_type) {
					case 0:
						saveDataOnFile(
							'data/'.$this->conf['_name'].'/LOOP'/*.'-'.date('Y/m/d H:i:s')*/,
							array_merge( array('UTC_date'=>date('Y/m/d H:i:s')), $LPS['LOOP'] = $this->RawConverter($this->Loop, $data)),
							FORMAT_JSON + FORMAT_PHP);
						break;
					case 1:
						saveDataOnFile(
							'data/'.$this->conf['_name'].'/LOOP2'/*.'-'.date('Y/m/d H:i:s')*/,
							array_merge( array('UTC_date'=>date('Y/m/d H:i:s')), $LPS['LOOP2'] = $this->RawConverter($this->Loop2, $data)),
							FORMAT_JSON + FORMAT_PHP);
					break;
					case 2:
						break;
					case 3:
						break;
				}
				
				if ($nbr>0) {
					sleep(2);
				}
				$nbr--;
			}
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
		return $LPS;
	}
/**
Lis les valeur d´archive a partir d´une date
	* @return: retourne un tableau de la forme :
	*	array (
	*		'Date Heure_0' => array ( Arch1, Arch2, ... ),
	*		'Date Heure_1' => array ( Arch1, Arch2, ... ),
	*		... );
	* @param: Date de la 1ere archive a lire (par defaut : 2012/01/01 00:00:00)
	*/
	function GetDmpAft($last, $save=true) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$DATAS=false;
		try {
			if (!$this->OffsetTime) $this->OffsetTime = $this->OffsetTime();
			$firstDate2Get=is_date($last);
			$this->RequestCmd("DMPAFT\n");
			$RawDate = DMPAFT_SetVP2Date($firstDate2Get);
			fwrite($this->fp, $RawDate);				// Send this date (parametre #1)

			$crc = CalculateCRC($RawDate);			// define the CRC of my date
			$this->RequestCmd($crc);					// Send the CRC (parametre #2)
			$data = fread($this->fp, 6);				// we read the properties : item count and first item position
			$this->VerifAnswersAndCRC($data, 6);
			$LastArchDate = 0;
			$nbrPages = hexToDec (strrev(substr($data,0,2)));	// Split Bytes in revers order : Nbr of page
			$firstArch = hexToDec (strrev(substr($data,2,2)));	// Split Bytes in revers order : # of first archived
				log_message('infos', 'There are '.$nbrPages.'p. in queue, from archive '.$firstArch.' on first page since '.$last.'.');
			fwrite($this->fp, ACK);				// Send ACK to start
			for ($j=0; $j<$nbrPages; $j++) {
				$ISS_time = time()%300;
				if ( $ISS_time<6 ) {
				// la recuperation des archives bloque la lecture des capteurs donc on le fait par petit bout
					throw new Exception(
                        i18n('cli-error.download:fail.label')
                    );
				}
				$Page = fread($this->fp, 267);
				log_message('infos', 'Archive PAGE #'.$j."\t".'Since: '.DMPAFT_GetVP2Date(substr($Page,1+52*($firstArch),4), $this->OffsetTime).' Sheets #[1,2,3,4,5]');
				$this->VerifAnswersAndCRC($Page, 267);
				fwrite ($this->fp, ACK);
				for ($k=$firstArch; $k<=4; $k++) {			// ignore les 1er valeur hors champ.
					$ArchiveStrRaw = substr ($Page, 1+52*$k, 52);
					$ArchDate = DMPAFT_GetVP2Date(substr($ArchiveStrRaw,0,4), $this->OffsetTime);
					if (strtotime($ArchDate) > strtotime($LastArchDate)) {
					// ignore les derniere valeur hors champ, car on parcoure une liste circulaire
					// donc la deniere valeur a extraire precede la plus vielle valleur de cette liste
						$DATAS = $this->RawConverter($this->DumpAfter, $ArchiveStrRaw);
						if ($save) {
							$this->save_Archive($DATAS);
							// log_message('save', sprintf(i18n('Page #%d-%d of %s archived Ok.'),$j, $k, $ArchDate));
						}
						$LastArchDate = $ArchDate;
					}
					else {
						throw new Exception(sprintf(
                            i18n('cli-info.block[%s%d%d]:out-of-range.label'),
                            $j, $k, $ArchDate
                        ));
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
Compare l'heure de la station a celle du serveur web et lance la synchro si besoin
	* @return: renvoi TRUE si deja a l'heure , renvoi l'heure en cas de Synchro reuci et FALSE en cas d'echec
	* @param: maxLag est la valeur maxi toleré pour le decalage, force==TRUE ignorera le decalage et force l'heure serveur'.
	*/
	function clockSync($maxLag, $force=false) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$TIME = False;
		// compare les date au format ISO 8601 (2004-02-12T15:19:21+00:00)
		$realLag = ($VP2_Time = strtotime($VP2_Time_Str = $this->fetchStationTime())) - strtotime(date('c'));

		log_message('warning',  "Real\t\t: ".date('c')."\n".$this->conf['_name']."\t: ".$VP2_Time_Str."\nLags\t\t: ".$realLag.' Sec');
		
		if (abs($realLag) > $maxLag) {
			if ($TIME = $this->updateStationTime(strftime('%Y-%m-%dT%H:%M:%S', $VP2_Time - $realLag))) { // date('Y-m-dTH:i:s')
				log_message('infos', i18n('Clock synchronizing.'));
			}
			// else log_message('warning', i18n( 'Clock synch. error'));
		}
		else if ($force) {
			// log_message('warning', sprintf(
   //              i18n('cli-warning.clock-sync[force].label')
   //          ));
			if ($TIME = $this->updateStationTime(date('Y-m-dTH:i:s'))) {
				log_message('infos', i18n('Clock synchronizing.'));
			}
			// else log_message('warning', i18n( 'Clock synch. error'));
		}
		else return true;

		log_message('infos', sprintf(
		    i18n('cli-infos.clock-sync[%s].label'),
		    $TIME
		));		
		return $TIME;
	}
/**
Lis l'heure de la station
	* @return: retourne l'heure de la station ou FALSE en cas d'echec
	* @param: none
	*/
	protected function fetchStationTime() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		// 0x35 16 00 1d 0c 6f  0x7c 44  ==  2011/12/29 00:22:53
		if (!$this->OffsetTime) $this->OffsetTime = $this->OffsetTime();

		$TIME = False;
		try {
			$this->RequestCmd("GETTIME\n");
			$TIME = fread($this->fp, 8);
			$this->VerifAnswersAndCRC($TIME, 8);
			$TIME = (ord($TIME[5])+1900)
				.'-'.str_pad(ord($TIME[4]),2,'0',STR_PAD_LEFT)
				.'-'.str_pad(ord($TIME[3]),2,'0',STR_PAD_LEFT)
				.'T'.str_pad(ord($TIME[2]),2,'0',STR_PAD_LEFT)
				.':'.str_pad(ord($TIME[1]),2,'0',STR_PAD_LEFT)
				.':'.str_pad(ord($TIME[0]),2,'0',STR_PAD_LEFT);
			$TIME = $TIME.$this->OffsetTime;

			return $TIME;
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
		return $TIME;
	}

/**
retourne le decalage horaire pour le fuseau horaire actif de cette stasion
	* @param
	* @var 
	* @return 
	*/
	function OffsetTime() {
		if ($this->conf['Time:Gmt:Enable']==1) {
			return $this->conf['Time:Gmt:Offset'];
		}
		elseif ($this->conf['Time:Gmt:Enable']==0) {
			return GetZoneOffset($this->conf['Geo:Time:Zone']);
		}
		return '+00:00';
	}

/**
Force l´heure de la station a la meme heure que le serveur web
	* @return: renvoi la nouvelle heure ou FALSE en cas d'echec
	* @param: none
	*/
	protected function updateStationTime($time) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		// 0x35 16 00 1d 0c 6f  0x7c 44  ==  2011/12/29 00:22:53
		try {
			$this->RequestCmd("SETTIME\n");
			list($_date, $_clock) = explode('T', $time);
			list($y,$m,$d) = explode('-', $_date);
			list($h,$i,$s) = explode(':', $_clock);
			$TIME = chr($s).chr($i).chr($h).chr($d).chr($m).chr($y-1900);
			$this->RequestCmd ($TIME . CalculateCRC($TIME));
			// log_message('infos', '[SETTIME] : '.$_date.' '.$_clock);
			return $_date.'T'.$_clock;
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
		return False;
	}

/**
decoupe la chaine de donne VP2 en segment pour chaque item de donnee
	* @return: protected functionReturn
	* @param: returnValue
	*/
	protected function subRaw($RawStr, $val) {
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

/**

	* @param
	* @var 
	* @return 
	*/
	protected function convertRaw($StrValue, $limits) {
	// Retourne la chaine binaire sous la forme Numerique dans l'unité de la VP2
	// retourne NULL si le capteur retourne la valeur d'erreur
		if (is_callable($limits['fn'])) {
			if ($limits['fn']=='DMPAFT_GetVP2Date')
				$val = DMPAFT_GetVP2Date ($StrValue, $this->OffsetTime);
			else
				$val = $limits['fn']($StrValue);
			if ($val == $limits['err']) {
// where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($val, $limits['err']));
							return NULL;
			}
			return $val;
		}
		return '<!> Missing function : ['.$limits['fn'].'] to convert RAW data.<!>';
	}

/**

	* @param
	* @var 
	* @return 
	*/
	protected function convertUnit($Value, $limits) {
	// Retourne la valeur numerique coverti en unité SI
	// Retourne FALSE si la valeur est incohérante.
		if (is_callable($limits['SI']) and !is_string($Value)) {
			if ($Value < $limits['min'] or $Value > $limits['max']) {
			// where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($Value , $limits['min'] , $limits['max']));
				return FALSE;
			}
			elseif ($limits['SI']=='RainSample2mm') {
				return $limits['SI']($Value, $this->conf['Rain:Collector:Size']);
			}
			return $limits['SI']($Value);
		}
		return $Value;
	}

/**
Converti la chaine de donnee VP2 en valeur numerique puis en unite SI
	* @param
	* @var 
	* @return 
	*/
	protected function RawConverter($DataModele, $RawStr) {
		$data = array();
		foreach($DataModele as $key=>$limits)
		// where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($key));
			$data[$key] = $this->convertUnit( $this->convertRaw( $this->subRaw( $RawStr, $limits), $limits), $limits);

		// where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,$data);
		return $data;
	}

/**
Enregistre les archives dans la base de donnée
	* @param
	* @var 
	* @return 
	*/
	protected function save_Archive($data){
		$this->current_data = $data;
		// var_dump($data);
		foreach ($data as $name => $val) {
			if ($val !== NULL and $val !== FALSE  ) {
			// si le capteur est branché ou si la valeur de retour n'est pas fausse 
				$table = tableOfSensor($name);
				// log_message('warning', '$table : '.print_r($table, true));
				$Sensor = $this->get_SEN_ID($name, $table);
				if ($table) {
					$eav = 'prep_EAV_'.$table[3];
					$this->$eav->execute(
						array_combine(
							$this->key_EAV,
							array($data['TA:Arch:none:Time:UTC'], $val, $Sensor['SENSOR_ID'])
						)
					);
					// echo 'Save in '. $table .'=>'. $name .'='. $Sensor['SENSOR_ID'] ." \n";
				}

			}
			// else log_message('data', 'No save in DB : '.$name.'	=	'.var_export($val, true));
		}
	}

/**
determine la date de la derniere archive recupérée
	* @param
	* @var 
	* @return 
	*/
	function get_Last_Date() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$date = $this->dataDB->query('SELECT MAX(UTC) as LAST_ARCH_DATETIME FROM `TA_VARIOUS`;');
		if (count($date->result_array())==1) {
			return $date->result_array[0]['LAST_ARCH_DATETIME'];
		}
		log_message('warning', 'Resultat inutilisable : '.print_r($date, true));
		return '2012/01/01T00:00:00';
	}
	

/**

	* @param
	* @var 
	* @return 
	*/
	protected function get_SEN_ID($name, $table, $recursive = true) {
		// where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$min = array('TA_TEMPERATURE'=>-50,'TA_HUMIDITY'=>0,'TA_WETNESSES'=>0,'TA_MOISTURE'=>0,'TA_VARIOUS'=>0);
		$max = array('TA_TEMPERATURE'=>80,'TA_HUMIDITY'=>100,'TA_WETNESSES'=>100,'TA_MOISTURE'=>100,'TA_VARIOUS'=>65000);
		$id = $this->dataDB->query('SELECT SEN_ID AS SENSOR_ID, SEN_MIN_REALISTIC AS MIN, SEN_MAX_REALISTIC AS MAX FROM `TR_SENSOR` WHERE SEN_NAME=\''.$name.'\' ;');
		//log_message('probe', 'Sensor ('.$name.' , '.$table.')'. print_r($id->result_array(),true) );

		if (count($id->result_array())==1) {

			return $id->result_array[0];
		}
		else if (count($id->result_array())==0 and $recursive==TRUE) { // $id->num_rows();
			$this->insert_SENSOR(array($name, 'HUMAN NAME is more than '.$name, 'DESCRIPT', 
				$min[$table], 
				$max[$table], 
				'unknow', 
				'unknow', 
				'standard', 32000, 0, date ("Y/m/d H:i:s"), 'P0Y6M0DT0H0M0S'));
/*			$this->dataDB->query('INSERT 
				INTO `TR_SENSOR` 
					(SEN_NAME, SEN_DEF_PLOT, SEN_MAX_ALARM, SEN_MIN_ALARM, SEN_LAST_CALIBRATE, SEN_CALIBRATE_PERIOD) 
				VALUES 
					(\''.$name.'\', \'Default_Plot\', 1999, -199, \'2012/01/01 00:00:01\', \'0000/06/00 00:00:00\')');*/
			return $this->get_SEN_ID($name, $table, false); // dataDB->insert_id(); // query('SELECT LAST_INSERT_ID();');
		}
		log_message('warning', 'Resultat inutilisable ('.$name.' , '.$table.')'. print_r($id->result_array(),true) );
	}



/**

	* @param
	* @var 
	* @return 
	*/
	protected function insert_SENSOR($value_SENSOR) {
		$real_SENSOR = array_combine($this->key_SENSOR, $value_SENSOR);
		//log_message('save', print_r($real_SENSOR, true));
		return $this->prep_SENSOR->execute($real_SENSOR);
	}

}