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
        $this->load->library('page_manager');

        $this->i18n->setLocaleEnv($this->config->item('probe:locale'), 'global');
    }

    /**
     * [index description]
     *
     * @param string $dataBinder D3js script to bind data to current page
     * @param string $station    working station
     * @param string $sensor     working sensor
     *
     * @return void
     */
    public function index($dataBinder = null, $station=null, $sensor=null)
    {
        if (empty($dataBinder) || !isset($dataBinder)) {
            $this->listView();
        } else {
            $this->binderView($dataBinder, $station, $sensor);
        }
    }

    /**
     * Prepare the view to display data and visualizer
     *
     * @param string $dataBinder JS script name used to bind data to the view
     * @param string $station    working station
     * @param string $sensor     working sensor
     *
     * @return view data visualization with dataBinder
     */
    public function binderView($dataBinder, $station=null, $sensor=null)
    {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());
        $page = new Page_manager();

        $data = $page->addMetadata($dataBinder);
        $data['viewer'] = true;
        // remove the controller name
        $data['dataBinder'] = $dataBinder;
        $data['station'] = $station;
        $data['sensor'] = $sensor;

        $data['breadcrumb'] = array(
            'list-viewer',
            array(
                'status'  =>  'active',
                'url'     =>  sprintf('/viewer/%s', $dataBinder),
                'i18n'    =>  sprintf('%s.view.label', $dataBinder)
            )
        );
// var_dump($data);
        // display the view
        $page->view(BINDER_DIR.$dataBinder, $data);
    }

    /**
     * create a clickable list of available views
     *
     * @return view list of available views
     */
    public function listView()
    {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());
        $page = new Page_manager();

        $data = $page->addMetadata('list-view');
        // remove the controller name
        $scannedDir = array_diff(scandir(BINDER_PATH), array('..', '.'));
        $data['list'] = array_map(array($this, 'prepareViewList'), $scannedDir);

        $data['breadcrumb'] = array(
            array(
                'status'  =>  'active',
                'url'     =>  '/viewer',
                'i18n'    =>  'list-viewer'
            )
        );
        // display the view
        $page->view('templates/list-viewer', $data);
    }

    /**
     * Display the list of data binder available in BINDER_PATH directory
     *
     * @param string  $file file or directory name
     * @param integer $key  index
     *
     * @return string [description]
     */
    public function prepareViewList($file, $key = null)
    {
        return (strstr($file, '.php') ? substr($file, 0, -4) : null);
    }

}
