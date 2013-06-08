<?php
/**
* Page builder
*
* @category Template
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */

/**
* Page builder
*
* Easily create pages, with correct title, author, description, etc.
*
* @category Template
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */
class Page_manager {
    /**
     * @var _CI object CodeIgniter global object (@see http://ellislab.com/codeigniter/user-guide/general/creating_libraries.html)
     */
    private $_CI;

    /**
     * @var array   data to pass to the view(s)
     */
    private $data = array();


    public function __construct() {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());
        $this->_CI =& get_instance();
    }

    /**
     * Passes data to the view and wrap it in header/footer and necessary HTML code
     *
     * @param string $page relative path to the view (from APPPATH/view directory)
     *
     * @return view the requested view
     */
    public function view($page)
    {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__);

        $view = 'application/views/'.$page.'.php';
        if ( ! file_exists($view)) {
            // Whoops, we don't have a page for that!
            show_error(
                array(
                    'error-title' => i18n('error.file:missing.title'),
                    'error-description' => i18n('error.file:missing.description'),
                    'error-solution' => sprintf(
                            i18n('solution.file:missing[%s].description'),
                            $page.'.php'
                        ).':'.$view.var_dump($this->data)
                    ),
                404,
                i18n('error.file:missing.header')
            );
        }

        $this->setStatus();

        $this->_CI->load->view('templates/header', $this->data);
        $this->_CI->load->view('templates/breadcrumb', $this->data);
        $this->_CI->load->view($page, $this->data);
        $this->_CI->load->view('templates/footer', $this->data);
        $this->_CI->load->view('templates/js-libs', $this->data);
    }

    public function setStatus(){
        if (!isset($this->data['viewer'])) {
            $this->addData('viewer', false );
        }

        $this->addData('isAuthentified', $this->isAuthentified() );
    }


    /**
     * Fetch common page data (title, description, author, etc.)
     *  this allow to use i18n string for the page date.
     *
     * @param $page
     * @return void
     */
    public function addMetadata($page)
    { //
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());
        $this->addData('page', $page );
        $this->addData('title', i18n(sprintf('%s.title.metadata', $page), true) );
        $this->addData('description', i18n(sprintf('%s.description.metadata', $page), true) );
        $this->addData('author', i18n('probe.authors.metadata', true) );
    }


    /**
     * Check if user is already authentified
     * @return boolean
     */
    private function isAuthentified() {
        try {
            if (isset($this->session)) {
                $status = unserialize($this->session->userdata("user"));
                return $status['Authentified'];
            } else {
                return false;
            }
        } catch (SessionException $e) {
            log_message('error',  $e->getMessage());
        }
    }


    /**
     * Add datum to the data to pass to the view(s).
     *
     * @param $k    string
     * @param $v    string
    */
    public function addData($k, $v)
    {
        $this->data[$k] = $v;
    }


    /**
     * Remove datum from the data to pass to the view(s).
     *
     * @param $k string
    */
    public function removeData($k){
        unset($this->data[$k]);
    }
}
