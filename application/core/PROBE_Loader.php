<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PROBE_Loader extends CI_Loader {
/**
	change protected > public to permit to unload modele with just : unset($this->my_modele);
	
	and add in your modele :
	function __destruct()
	{
		log_message('debug', __FUNCTION__.'('.__CLASS__.') '.__FILE__);
		unset ($this->load->_ci_models [array_search (__CLASS__, $this->load->_ci_models)]);
	}

	
*/
	/**
	 * List of loaded classes
	 *
	 * @var array
	 * @access protected > public by alban.lopez
	 */
	public $_ci_classes			= array();
	/**
	 * List of loaded models
	 *
	 * @var array
	 * @access protected > public by alban.lopez
	 */
	public $_ci_models			= array();

	public function __construct()
	{
		parent::__construct();
		log_message('debug', __class__." Class Initialized extends CI_Loader");
	}
	public function unload($item)
	{
		if (is_array($item)) {
			foreach ($item as $babe) {
				$this->unload($babe);
			}
			return;
		}

		if (empty($item)) {
			return;
		}
		if (in_array($item, $this->_ci_models, TRUE)) {
			unset ($this->_ci_models [array_search ( $item , $this->_ci_models)]);
			unset($this->$item);
			$CI =& get_instance();
			unset($CI->$item);
			log_message('debug',  'Unload modele : '.$item);
		}
		else log_message('debug',  'ce modele n\'existe plus : '.$item);
	}
	public function model($model, $name = '', $db_conn = FALSE)
	{
		if (is_array($model))
		{
			foreach ($model as $babe)
			{
				$this->model($babe);
			}
			return;
		}

		if ($model == '')
		{
			return;
		}

		$path = '';

		// Is the model in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos($model, '/')) !== FALSE)
		{
			// The path is in front of the last slash
			$path = substr($model, 0, $last_slash + 1);

			// And the model name behind it
			$model = substr($model, $last_slash + 1);
		}

		if ($name == '')
		{
			$name = $model;
		}

		if (in_array($name, $this->_ci_models, TRUE))
		{
			return;
		}

		$CI =& get_instance();
		if (isset($CI->$name))
		{
			show_error('The model name you are loading is the name of a resource that is already being used: '.$name);
		}

		$model = strtolower($model);

		foreach ($this->_ci_model_paths as $mod_path)
		{
			if ( ! file_exists($mod_path.'models/'.$path.$model.'.php'))
			{
				continue;
			}

			if ($db_conn !== FALSE AND ! class_exists('CI_DB'))
			{
				if ($db_conn === TRUE)
				{
					$db_conn = '';
				}

				$CI->load->database($db_conn, FALSE, TRUE);
			}

			if ( ! class_exists('CI_Model'))
			{
				load_class('Model', 'core');
			}

			require_once($mod_path.'models/'.$path.$model.'.php');

			$model = ucfirst($model);

// improve by alban.lopez for transmit arguments to __contruct() of loadel module
			if (func_num_args() > 3) {
				$refl = new ReflectionClass($model);
				$CI->$name = $refl->newInstanceArgs(array_slice(func_get_args(), 3));
			}
			else {
				$CI->$name = new $model();
			}
// improve by alban.lopez for transmit arguments to __contruct() of loadel module

			$this->_ci_models[] = $name;
			return;
		}

		// couldn't find the model
		show_error('Unable to locate the model you have specified: '.$model);
	}
}