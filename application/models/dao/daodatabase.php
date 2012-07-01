<?php
abstract class DaoDatabase extends CI_Model {
    function __construct() {
        parent::__construct();
        //$this->load->database();
        $this->load->library('WsWdsPdo');
    }
}
?>