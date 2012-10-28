<?php
class Pages extends CI_Controller {

/*
@description: wrap page in HTML
*/
function view($page, $data = null) {where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		 //
// echo $page;
    if ( ! file_exists('application/views/'.$page.'.php')) {
        // Whoops, we don't have a page for that!
        show_404();
    }

    $this->load->view('templates/header', $data);
    $this->load->view($page, $data);
    $this->load->view('templates/footer', $data);

}

//     function __construct() {
//where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		//         parent::__construct();
// //         $this->setPathToWorkingDir($GLOBALS['workingFolder']);
//     }


}
?>