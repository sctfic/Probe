<?php
/**
* Set of miscellaneous helpers
*
* @category Template
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */

/**
 * Random string generation
 *
 * @param integer $length   length of the generated string
 * @param string  $alphabet characters set to use to generate the string
 *
 * @return [type] [description]
 */
function randomPassword($length=8, $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789")
{
    for ($i = 0; $i < $length; $i++) {
        $pos = rand(0, strlen($alphabet)-1);
        $pass[$i] = $alphabet[$pos];
    }

    return implode($pass);
}

/**
* this function write in APPPATH.'config/db-default.php' file the
* necessary connection config to reconnect later
* @param array () of config
**/
/*function array2conf_php($file, $conf_val, $conf_name="db['default']") {
    if (file_put_contents($file, "<?php\n\$".$conf_name." = ".var_export($conf_val, true).";") === FALSE)
        throw new Exception( i18n('Impossible d ecrire le fichier de config : '.APPPATH.'config/db-default.php') );

    return true;
}*/

/**
 * log the current file, class, function, line, argumets
 *
 * @param string  $file  file path
 * @param string  $class class name
 * @param integer $func  function name
 * @param string  $line  line number
 * @param string  $args  list of arguments as (@see func_get_args:http://fr2.php.net/manual/en/function.func-get-args.php)
 *
 * @return void write to log file
 */
function where_I_Am($file, $class, $func, $line, $args=null)
{
    $argsList = (empty($args)?'':"\n".str_replace(array(" ", "\t", "\r", "\n", '['), array('', '', '', '', ' ['), print_r($args, true)));
    log_message(
        'current',
        sprintf("%s [%s]:%s/%s(%s)", basename($file), $line, $class, $func, $argsList)
    );
}

const FORMAT_TXT = 1;
const FORMAT_JSON = 2;
const FORMAT_PHP = 4;
const FORMAT_SERIALIZED = 8;
const FORMAT_XML = 16;

/**
 * helper to write into file
 * to reduce function complexity @see @see http://stackoverflow.com/questions/8388410/fix-code-with-high-npath-complexity
 *
 * @param string $file   file to write to (no prefix)
 * @param mixed  $data   data to write
 * @param string $format file format (TXT = 1, JSON = 2, PHP = 4, SERIALIZED = 8, XML = 16)
 * @param string $label  label to write at the begin of file
 *
 * @return void [description]
 */
function saveDataOnFile($file, $data, $format, $label=null)
{
    $result = false;

    if (basename($file)==$file)
        $file = FCPATH.'data/'.$file;
    if (empty($label))
        $label = basename($file);

    $targetDir = dirname($file);
    where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, array($targetDir, $file, $format, $label));

    if (!is_dir($targetDir))
        if (!mkdir($targetDir, 0775, true))
            throw new Exception(sprintf(i18n('error.file[%s].creation'), $targetDir));

    if (!is_writable($targetDir)) {
        log_message('error', sprintf(i18n('error.file[%s].creation'), $targetDir));
        throw new Exception(sprintf(i18n('error.file[%s].creation'), $targetDir));
    } else {
        Serialization($file, $data, $format, $label);
    }

    return $result;
}

/**
 * build the filename and serialize the data in the correct format
 *
 * @param string $file   file to write to (no prefix)
 * @param mixed  $data   data to write
 * @param string $format file format (TXT = 1, JSON = 2, PHP = 4, SERIALIZED = 8, XML = 16)
 * @param string $label  label to write at the begin of file
 *
 * @return integer returns the number of bytes that were written to the file,
 *                         or FALSE on failure (@see http://fr2.php.net/manual/en/function.file-put-contents.php).
 */
function Serialization($file, $data, $format, $label = null)
{
    if (($format & FORMAT_TXT) == FORMAT_TXT) {
        $filename = $file.'.txt';
        file_put_contents($filename, print_r($data, true));
    }
    if (($format & FORMAT_SERIALIZED) == FORMAT_SERIALIZED) {
        $filename = $file.'.serialized';
        file_put_contents($filename, serialize($data));
     }
    if (($format & FORMAT_PHP) == FORMAT_PHP) {
        $filename = $file.'.php';
        file_put_contents($filename, sprintf("<?php\n\$%s = %s;", $label, var_export($data, true)));
    }
    if (($format & FORMAT_JSON) == FORMAT_JSON) {
        $filename = $file.'.json';
        file_put_contents($filename, json_encode($data));
    }
    if ($format & FORMAT_XML == FORMAT_XML) {
        $filename = $file.'.xml';
        file_put_contents($filename, highlight_string(print_r($data, true), true));
    }
}
    /**
        identifie la table qui correspond a notre type de donnée, parmis les tables EAV
    */
    function tableOfSensor($name) {
        if (strpos($name, ':Temp:') !== false)
            return 'TA_TEMPERATURE';
        elseif (strpos($name, ':Hum:') !== false)
            return 'TA_HUMIDITY';
        elseif (strpos($name, ':LeafWetnesses:') !== false)
            return 'TA_WETNESSES';
        elseif (strpos($name, ':SoilMoisture:') !== false)
            return 'TA_MOISTURE';
        elseif (strpos($name, ':Various:') !== false)
            return 'TA_VARIOUS';
        return false;
    }

if ( ! function_exists('deep_ksort'))
{
    // blank ! " # $ % & ' ( ) * + , - . / 0 1 2 3 4 5 6 7 8 9 : ; < = > ? @
    // A B C D E F G H I J K L M N O P Q R S T U V W X Y Z [ \ ] ˆ_
    // a b c d e f g h i j k l m n o p q r s t u v w x y z { } ~
    function deep_ksort(&$arr) {
        ksort($arr); 
        foreach ($arr as &$a) { 
            if (is_array($a) && !empty($a)) { 
                deep_ksort($a); 
            } 
        } 
    }
}