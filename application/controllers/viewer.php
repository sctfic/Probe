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
     * @var array data for the breadcrumbs related to installation
     */
    protected  $_breadcrumb = array(
        'dashboard' => array(// in case list-station isn't the home anymore
            array(
                'status' => 'active',
                'url' => '/dashboard',
                'i18n' => 'viewer.dashboard.breadcrumb'
            )
        ),
        'list-viewer' => array(
            array(
                'url' => '/dashboard',
                'i18n' => 'viewer.dashboard.breadcrumb'
            ),
            array(
                'status' => 'active',
                'url' => '/viewer/list',
                'i18n' => 'viewer.list.breadcrumb'
            ),
        ),
    );


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

        // build view data
        $page->addMetadata($dataBinder);
        $page->addData('breadcrumb',
            $this->_breadcrumb['dashboard']
            +
            array(
                'status'  =>  'active',
                'url'     =>  sprintf('/viewer/%s', $dataBinder),
                'i18n'    =>  sprintf('%s.view.label', $dataBinder)
            )
        );
        $page->addData('viewer', true);
        $page->addData('dataBinder', $dataBinder);
        $page->addData('station', $station);
        $page->addData('sensor', $sensor);

        // display the view
        $page->view(BINDER_DIR.$dataBinder);
    }


    /**
     * create a clickable list of available views
     *
     * @return view list of available views
     */
    public function listView()
    {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());
        // remove the controller name
        $scannedDir = array_diff(scandir(BINDER_PATH), array('..', '.'));

        $page = new Page_manager();

        $page->addMetadata('list-view');
        $page->addData('breadcrumb', $this->_breadcrumb['list-viewer']);
        $page->addData('list', array_map(array($this, 'prepareViewList'), $scannedDir));

        // display the view
        $page->view('templates/list-viewer');
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
