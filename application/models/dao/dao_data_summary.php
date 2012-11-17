<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class filteredData extends CI_Model {
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
mini courbes sans axes ni legendes : 64px * 128px
* @param is the sensor name
*/
	function curves($sensor){
	}

/**
mini rose des vents a 8 directions, 64px sans aucune legende
* @param hour is number of hour avg
*/
	function windrose($hour){

	}


}