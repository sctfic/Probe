<?php
/**
* Data Viewer
*
* @category Viewer
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */
// namespace Probe\Install;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once APPPATH."/controllers/checkSetup.php";
require_once APPPATH."/controllers/pages.php";

/**
* Manage the installation and configuration of the application
*
* @category Install
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */
class viewer extends CI_Controller
{
    /**
     * entry point
     */
    public function __construct()
    {
        parent::__construct();
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());
    }

    /**
     * [index description]
     *
     * @param string $dataBinder D3js script to bind data to current page
     *
     * @return [type] [description]
     */
    public function index($dataBinder = null)
    {
        $this->load->helper('pages');

        if (empty($dataBinder) || !isset($dataBinder)) {
            show_404();
        }

        // build view data and fetch information to build the HTML header
        $data = pageFetchConfig($dataBinder);
        $data['viewer'] = true;
        // remove the controller name
        $data['dataBinder'] = $dataBinder;

        // display the view
        $pages = new Pages();
        $pages->view('d3/'.$dataBinder, $data);
    }
}
