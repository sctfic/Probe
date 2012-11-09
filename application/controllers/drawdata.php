<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class drawData extends CI_Controller {
/**
Cette classe appelle les differentes requetes
en vu de les retourner au scripte ajax qui les dessinera
*/
	function __construct() {
		parent::__construct();
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

	}

/**

* @
* @param 
* @param 
*/
	function index(){

	}

/**

* @
* @param since is the start date of result needed
* @param lenght is the number of day
* @param is the sensor name (one or more)
*/
	function curves($since, $lenght){
		
		$args = func_get_args();
	    foreach ($args as $value) {
	     	
	    }
	}
/**

* @
* @param since is the start date of result needed
* @param lenght is the number of day
* @param is the sensor name (one or more)
*/
	function bracketCurve($since, $lenght){
		
		$args = func_get_args();
	    foreach ($args as $value) {
	     	
	    }
	}

/**

* @
* @param since is the start date of result needed
* @param lenght is the number of day
*/
	function windrose($since, $lenght){

	}


}