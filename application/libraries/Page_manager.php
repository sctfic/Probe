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

    public function __construct() {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());
        $this->_CI =& get_instance();
    }

    /**
     * Passes data to the view and wrap it in header/footer and necessary HTML code
     *
     * @param string $page relative path to the view (from APPPATH/view directory)
     * @param array  $data parameters needed by the view
     *
     * @return view the requested view
     */
    public function view($page, $data = null)
    {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__);

        $view = 'application/views/'.$page.'.php';
        if ( ! file_exists($view)) {
            // Whoops, we don't have a page for that!
            show_error(
                array(
                    'error-title' => i18n('error.file.missing.title'),
                    'error-description' => i18n('error.file.missing'),
                    'error-solution' => sprintf(
                            i18n('solution.file[%s].missing'),
                            $page.'.php'
                        ).':'.$view.var_dump($data)
                    ),
                404,
                i18n('error.file.missing.header')
            );
        }

        if (!isset($data['viewer'])) {
            $data['viewer'] = false;
        }

        $this->_CI->load->view('templates/header', $data);
        $this->_CI->load->view('templates/breadcrumb', $data);
        $this->_CI->load->view($page, $data);
        $this->_CI->load->view('templates/footer', $data);
        $this->_CI->load->view('templates/js-libs', $data);
    }

    /**
     * Fetch common page data (title, description, author, etc.)
     *  this allow to use i18n string for the page date.
     * @param $page
     * @return array
     */
    public function fetchConfig($page)
    { //
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());
        $data = array();
        $data['page'] = $page;
        $data['title'] = i18n($page . ':title', true);
        $data['description'] = i18n($page . ':description', true);
        $data['author'] = i18n('probe:authors', true);

        return $data;
    }
}
