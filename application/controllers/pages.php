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
class pages extends CI_Controller
{
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
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());

        if ( ! file_exists('application/views/'.$page.'.php')) {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $this->load->view('templates/header', $data);
        $this->load->view($page, $data);
        $this->load->view('templates/footer', $data);
        $this->load->view('templates/js-libs', $data);
    }
}
