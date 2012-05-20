<?php	// clear;php5 -f ./StationScript/VP2-IP/index.php

class abstract ConnexionManager
{
	protected $fp=NULL;	// Pointer of VP2 Connection
	protected $backLightScreen=FALSE; // actual state of backlight screen
	protected $table = null;
/*	protected $IP = null;
	protected $Port = null;*/
	protected $conf = null;
	public $_version = 0.16;


	function __construct($name, $myConfig)	{
		$this->setStationFolder( dirname(__FILE__).DIRECTORY_SEPARATOR );
/*		$this->IP = $myConfig['IP'];
		$this->Port = $myConfig['Port'];*/
		$this->conf = $myConfig;
// 		$this->setStationConfig($stationConfig);
		require ($this->StationFolder.'Tools.c.php');
		require ($this->StationFolder.'EepromDumpAfter.h.php');
		require ($this->StationFolder.'EepromLoop.h.php');
		require ($this->StationFolder.'EepromHiLow.h.php');
		require ($this->StationFolder.'EepromConfig.h.php');	
	}
	

	public function initConnection()	{
		for ($i=1;$i>=0;$i--){
			$errno = 0;
			$this->fp = @fsockopen(
				$this->conf['IP'],
				$this->conf['Port'],
				&$errno
			);
			if ($this->fp && $errno==0)
			{
				stream_set_timeout($this->fp, 0, 2500000);
				if ($this->wakeUp())
				{
					$this->toggleBacklight(1);
					return TRUE;
				}
				else
				{
					sleep(2*$i);
					$this->CloseConnection();
					sleep(2*$i);
				}
			}
		}
		return FALSE;
	}
	protected function wakeUp()	{
		for ($i=0;$i<=$this->retry;$i++) {
			fwrite ($this->fp,Tools::symb['LF']);
			if (fread($this->fp,6)==Tools::symb['LFCR'])
				return TRUE;
			usleep(1200000);
		}
		return FALSE;
	}
	protected function toggleBacklight($force=-1) {
		if ($force==-1) {
			fwrite ($this->fp,'LAMPS '.(($this->backLightScreen)?'0':'1').Tools::symb['LF']);
		}
		else {
			fwrite ($this->fp,'LAMPS '.($force?'1':'0').Tools::symb['LF']);
		}
		if (fread($this->fp,6)==Tools::symb['_OK_']) {
			if ($force==-1)$this->backLightScreen = !$this->backLightScreen;
			else $this->backLightScreen = $force;
			return TRUE;
		}
		return FALSE;
	}

	function CloseConnection()	{
		$this->toggleBacklight(0);
		if (fclose($this->fp))
			return TRUE;
		else return FALSE;
	}


	function fetchStationTime()	{// 0x35 16 00 1d 0c 6f  0x7c 44  ==  2011/12/29 00:22:53
		fwrite ($this->fp, "GETTIME\n");
		$r = fread($this->fp, 1);
		if ($r == Tools::symb['ACK'])
		{
			$GETTIME = fread($this->fp, 8);
			if (strlen($GETTIME)==8 && Tools::CalculateCRC($GETTIME)==0x0000)
			{
				$GETTIME = (ord($GETTIME[5])+1900).'/'.str_pad(ord($GETTIME[4]),2,'0',STR_PAD_LEFT).'/'.str_pad(ord($GETTIME[3]),2,'0',STR_PAD_LEFT).' '.str_pad(ord($GETTIME[2]),2,'0',STR_PAD_LEFT).':'.str_pad(ord($GETTIME[1]),2,'0',STR_PAD_LEFT).':'.str_pad(ord($GETTIME[0]),2,'0',STR_PAD_LEFT);
				$this->Waiting (0, 'Real Time : '.date('Y/m/d H:i:s').' vs GETTIME : '.$GETTIME);
				return $GETTIME;
			}
			else
				$this->Waiting (0,'[GETTIME] : Erreur de CRC');
		}
		else
		{
			fread($this->fp, 666);
				$this->Waiting (0,'[GETTIME] : unknown Error '.ord($r).'='.ord(Tools::symb['ACK']));
		}
		return FALSE;
	}
	function updateStationTime()	{// 0x35 16 00 1d 0c 6f  0x7c 44  ==  2011/12/29 00:22:53
		fwrite ($this->fp, "SETTIME\n");
		$r = fread($this->fp, 1);
		if ($r == Tools::symb['ACK'])
		{
			list($_date, $_clock) = explode(' ', date('Y/m/d H:i:s'));
			list($y,$m,$d) = explode('/', $_date);
			list($h,$i,$s) = explode(':', $_clock);
			$SETTIME = chr($s).chr($i).chr($h).chr($d).chr($m).chr($y-1900);
			$crc = Tools::CalculateCRC($SETTIME);
			fwrite ($this->fp, $SETTIME.$crc);
			$r = fread($this->fp, 1);
			if ($r == Tools::symb['ACK'])
			{
				$this->Waiting (0,'[SETTIME] : '.$_date.' '.$_clock);
				return $_date.' '.$_clock;
			}
			else
				$this->Waiting (0,'[SETTIME] : invalid date.');
		}
		else
		{
			fread($this->fp, 666);
				$this->Waiting (0,'[SETTIME] : unknown Error');
		}
		return FALSE;
	}
	function clockSync($maxLag)	{
		$realLag = abs(strtotime($this->fetchStationTime()) - strtotime(date('Y/m/d H:i:s')));
		if ($realLag > $maxLag) {	// OK
			$this->Waiting( 0, sprintf( _('[Infos] Default Clock synchronize : %ssec'), $realLag) );
			if ($this->updateStationTime())								// OK
				$this->Waiting (0,_('[Infos] Clock synchronizing.'));					// OK
			else $this->Waiting( 0, _( '[Echec] Clock synch.'));
		}
	}


}
?>
