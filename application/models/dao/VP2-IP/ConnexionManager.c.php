<?php	// clear;php5 -f ./StationScript/VP2-IP/index.php

require (dirname(__FILE__).DIRECTORY_SEPARATOR.'Tools.c.php');
class ConnexionManager {
	protected $fp=NULL;	// Pointer of VP2 Connection
	protected $backLightScreen=FALSE; // actual state of backlight screen
	protected $table = null;
/*	protected $IP = null;
	protected $Port = null;*/
	protected $conf = null;
	public $_version = 0.16;


	function __construct($name, $myConfig)	{
		$this->StationFolder = dirname(__FILE__).DIRECTORY_SEPARATOR;
/*		$this->IP = $myConfig['IP'];
		$this->Port = $myConfig['Port'];*/
		$this->conf = $myConfig;
// 		$this->setStationConfig($stationConfig);
		require ($this->StationFolder.'EepromDumpAfter.h.php');
		require ($this->StationFolder.'EepromLoop.h.php');
		require ($this->StationFolder.'EepromHiLow.h.php');
		require ($this->StationFolder.'EepromConfig.h.php');	
	}

	public function initConnection()	{
// 		for ($i=1;$i>=0;$i--){
		$errno = 0;
		$this->fp = @fsockopen (
			$this->conf['IP'],
			$this->conf['Port']
		);
		if ($this->fp && $errno==0) {
			stream_set_timeout ($this->fp, 0, 2500000);
			if ($this->wakeUp()) {
				$this->toggleBacklight (1);
				return TRUE;
			}
			else {
				fclose($this->fp);
			}
		}
// 		}
		return FALSE;
	}
	protected function wakeUp()	{
		for ($i=0;$i<=3;$i++) {
			fwrite ($this->fp, Tools::LF);
			if (fread($this->fp,6)==Tools::LFCR)
				return TRUE;
			usleep(1200000);
		}
		return FALSE;
	}
	protected function toggleBacklight($force=-1) {
		if ($force==-1) {
			fwrite ($this->fp,'LAMPS '.(($this->backLightScreen)?'0':'1').Tools::LF);
		}
		else {
			fwrite ($this->fp,'LAMPS '.($force?'1':'0').Tools::LF);
		}
		if (fread($this->fp,6)==Tools::OK) {
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

	function CloseConnection()	{
		$this->toggleBacklight(0);
		if (fclose($this->fp))
			return TRUE;
		else return FALSE;
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
		
		$crc = Tools::CalculateCRC($data);
		if ($crc != Tools::DBL_NULL /* chr(0).(0) "\x00\x00" */ ){
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
		if ($r == Tools::ACK){
			return true;
		}
		else if ($r == Tools::NAK)
		{
			throw new Exception(sprintf(_('Command [%s] not understand'),$cmd));
		}
		else {
			throw new Exception(_('Unknow Error, Reconnection'));
		}
	}

}
?>