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

        $this->i18n->setLocaleEnv($this->config->item('probe:locale'), 'global');

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
            $this->listView();
        } else {
            $this->binderView($dataBinder);
        }
    }

    /**
     * prepare the view to display data and visualizer
     *
     * @param string $dataBinder JS script name used to bind data to the view
     *
     * @return view data visualization with dataBinder
     */
    public function binderView($dataBinder)
    {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());

        $data = pageFetchConfig($dataBinder);
        $data['viewer'] = true;
        // remove the controller name
        $data['dataBinder'] = $dataBinder;

        $data['breadcrumb'] = array(
            'viewer.list',
            array(
                'status'  =>  'active',
                'url'     =>  '/viewer/'.$dataBinder,
                'i18n'    =>  'viewer.'.$dataBinder
            )
        );

        // display the view
        $pages = new Pages();
        $pages->view(BINDER_DIR.$dataBinder, $data);
    }

    /**
     * create a clickable list of available views
     *
     * @return view list of available views
     */
    public function listView()
    {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());

        $this->load->helper('pages');

        $data = pageFetchConfig('list-view');
        // remove the controller name
        $scannedDir = array_diff(scandir(BINDER_PATH), array('..', '.'));
        $data['list'] = array_map(array($this, 'prepareViewList'), $scannedDir);

        $data['breadcrumb'] = array(
            array(
                'status'  =>  'active',
                'url'     =>  '/viewer',
                'i18n'    =>  'viewer.list'
            )
        );
        // display the view
        $pages = new Pages();
        $pages->view('templates/viewer-list', $data);
    }

    /**
     * Display the list of data binder available in BINDER_PATH directory
     *
     * @param string  $file file or directory name
     * @param integer $key  index
     *
     * @return [type] [description]
     */
    public function prepareViewList($file, $key = null)
    {
        return (strstr($file, '.php') ? substr($file, 0, -4) : null);
    }

}
