<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------
/**
 * Logging Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Logging
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/errors.html
 */
class CI_Log {
	protected $_log_path;
	protected $_threshold	= 1;
	protected $_verbose	= 1;
	protected $_date_fmt	= 'Y-m-d H:i:s';
	protected $_enabled	= TRUE;
	protected $_levels	= array('ERROR' => 1, 'DEBUG' => 2, 'WARNING' => 3, 'INFO' => 4, 'CLI' => 5, 'PROBE' => 6, 'I18N' => 7, 'CURRENT' => 8, 'ALL' => 9);

	public function __construct()
	{
		$config =& get_config();
		$this->_log_path = ($config['log_path'] != '') ? $config['log_path'] : APPPATH.'logs/';
		if ( ! is_dir($this->_log_path) OR ! is_really_writable($this->_log_path))	{
			$this->_enabled = FALSE;
		}
		if (is_numeric($config['log_threshold']))	{
			$this->_threshold = $config['log_threshold'];
		}
		if (is_numeric($config['verbose_threshold']))	{
			$this->_verbose = $config['verbose_threshold'];
		}
		if ($config['log_date_format'] != '')	{
			$this->_date_fmt = $config['log_date_format'];
		}
	}

	/**
	 * Write Log File
	 * Generally this function will be called using the global log_message() function
	 * @param	string	the error level
	 * @param	string	the error message
	 * @param	bool	whether the error is a native PHP error
	 * @return	bool
	 */
	public function write_log($level = 'error', $msg, $php_error = FALSE)
	{
		if ($this->_enabled === FALSE)	{
			return FALSE;
		}
		$level = strtoupper($level);
		if (!array_key_exists($level, $this->_levels))	{
			$this->_levels[$level] = 8;
		}
		$filepath = $this->_log_path.'log-'.date('Y-m-d').'.php';
		
		$message  = '';
		$header = '';
		
		if ( ! file_exists($filepath))	{
			$header = "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
		}
		
		if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))	{
			return FALSE;
		}
		$message .= $level."\t- ".date($this->_date_fmt). ' -> '.str_replace ("\n", "\n\t\t\t\t> ", $msg)."\n";
		
		if ($this->_levels[$level] <= $this->_verbose && $this->_levels[$level] > 2)	{
			if (RUNNER=='WEB' and $this->_levels[$level]<=3) // en web
				echo nl2br($message);
			elseif (RUNNER=='WEB') // en web
				echo '<!-- '.nl2br($message).' -->';
			elseif(RUNNER=='CLI') // en CLI
				echo $message;
		}
		
		if (($this->_levels[$level] > $this->_threshold))	{
			return FALSE;
		}
		if ( preg_match('/Total execution time:/', $msg) )	{
			$message .= "\tEND\n\n\tNEW\n";
		}
		
		flock($fp, LOCK_EX);
		fwrite($fp, $header.$message);
		flock($fp, LOCK_UN);
		fclose($fp);
		//@chmod($filepath, FILE_WRITE_MODE);
		return TRUE;
	}
}
// END Log Class

/* End of file Log.php */
/* Location: ./system/libraries/Log.php */
