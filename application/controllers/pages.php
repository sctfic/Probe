<?php
class Pages extends CI_Controller {

/*
@description: wrap page in HTML
*/
function view($page, $data = null) { //
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
//         parent::__construct();
// //         $this->setPathToWorkingDir($GLOBALS['workingFolder']);
//     }


}
?>