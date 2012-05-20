<?php
// ##############################################################################################
/// IX. Data Formats (See docs on pages 28, 29)
/// 3. DMP and DMPAFT data format
/// There are two different archived data formats. Rev "A" firmware, dated before April 24, 2002
/// uses the old format. Rev "B" firmware dated on or after April 24, 2002 uses the new format. The
/// fields up to ET are identical for both formats. The only differences are in the Soil, Leaf, Extra
// ##############################################################################################

function VerifAnswersAndCRC($data, $len) {
	if (strlen($data)!=$len){
		throw new Exception(sprintf(_('Incomplete Data strlen = %d insted of : %d'),strlen($data),$len));
	}
	
	$crc = $this->CalculateCRC($data);
	if ($crc !== chr(0).chr(0)){
		throw new Exception(sprintf(_('Wrong CRC, on good data : 0x%X'),$crc));
	}
	return true;
}
/*
@description: functionDescription
@return: functionReturn
@param: returnValue
*/
function RequestCmd($cmd) { //
	fwrite ($this->fp, $cmd);
	$r = fread($this->fp, 1);
	if ($r == $this->symb['ACK']){
		return true;
	}
	else if ($r == $this->symb['NAK'])
	{
		throw new Exception(sprintf(_('Command [%s] not understand'),$cmd));
	}
	else {
		throw new Exception(_('Unknow Error, Reconnection'));
	}
}


function GetLoop ($nbr=1)
{
	try {
		RequestCmd("LOOP $nbr\n");
		while ($nbr-- > 0)
		{
			$data = fread($this->fp, 99);
			VerifAnswersAndCRC&CRC($data, 99);
			$this->Waiting (0,'[LOOP] : Download the current Values');


	}
	catch (Exception $e) {
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
	}
}
?>
