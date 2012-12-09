<?php
/**
 this function generate a random string
* @param size of string
* @param list of autorized char
**/
function randomPassword($size=8, $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789") {
	for ($i = 0; $i < $size; $i++) {
		$n = rand(0, strlen($alphabet)-1);
		$pass[$i] = $alphabet[$n];
	}
	return implode($pass);
}
/**
 this function write in APPPATH.'config/db-default.php' file the 
* necessary connection config to reconnect later
* @param array () of config
**/
/*function array2conf_php($file, $conf_val, $conf_name="db['default']") {
	if (file_put_contents($file, "<?php\n\$".$conf_name." = ".var_export($conf_val, TRUE).";") === FALSE)
		throw new Exception( i18n('Impossible d ecrire le fichier de config : '.APPPATH.'config/db-default.php') );
	return true;
}*/
function where_I_Am ($f, $c, $fn, $l, $args=null) {
	log_message('current',  basename($f).'['.$l."]: ".$c.'->'.$fn.'('.(empty($args)?'':"\n".str_replace(array(" ","\t","\r","\n",'['),array('','','','',' ['),print_r($args,true))).' )');
}

const FORMAT_TXT = 1;
const FORMAT_JSON = 2;
const FORMAT_PHP = 4;
const FORMAT_SERIALIZED = 8;
const FORMAT_XML = 16;

function saveDataOnFile($file,$data,$format,$data_var_name=null) {

	if (basename($file)==$file)
		$file = FCPATH.'data/'.$file;
	if (empty($data_var_name))
		$data_var_name = basename($file);

	where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array(dirname($file),$file,$format,$data_var_name));
	
	if (!is_dir(dirname($file)))
		if (!mkdir(dirname($file), 0777, true))
			throw new Exception( 'Unable to create : '.dirname($file).' !' );
	if (!is_writable(dirname($file))) {
		log_message('error', dirname($file).' is not writable !');
		throw new Exception( dirname($file).' is not writable !' );
	}
	else {
		if (($format & FORMAT_TXT) == FORMAT_TXT) {
			file_put_contents( $file.'.txt', print_r($data, TRUE) );
		}

		if (($format & FORMAT_SERIALIZED) == FORMAT_SERIALIZED) {
			file_put_contents( $file.'.serialized', serialize($data) );
		}

		if (($format & FORMAT_PHP) == FORMAT_PHP) {
			file_put_contents( $file.'.php', "<?php\n\$".$data_var_name." = ".var_export($data, TRUE).";" );
		}

		if (($format & FORMAT_JSON) == FORMAT_JSON) {
			file_put_contents ( $file.'.json', json_encode($data) );
		}

		if ($format & FORMAT_XML == FORMAT_XML) {
			file_put_contents( $file.'.xml', highlight_string( print_r($data, TRUE), TRUE ) );
		}		
	}
}