<?php
/**[VP2-Outside] => Array
        (
            [Name] => VP2-Outside
            [IP] => wswds.no-ip.org
            [Port] => 22222
            [Type] => VP2-IP
            [DB] => DB2
            [Longitude] => 44.2
            [Latitude] => 0.3
            [Elevation] => 73
        )**/

class station extends CI_Model {
	protected $data = NULL;
	public $type = NULL;
	public $name = NULL;
	public $conf = NULL;
	
	function __construct($conf)
	{
		parent::__construct();
		$this->type = $conf['type'];
// 		unset ($conf['type']);
		$this->name = $conf['name'];
// 		unset ($conf['name']);
		$this->conf = $conf;
		$this->load->model($this->type);

	}
	function get_archives()
	{
		echo sprintf ("\n%'+40s %16s %'+40s\n", "", $name, "");

	}

	function get_confs()
	{
		
	}
}