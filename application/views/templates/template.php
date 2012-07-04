<?php
// var_dump($page);
    $this->load->view('templates/header', $data);
        $this->load->view($page);
    $this->load->view('templates/footer', $data);
    $this->load->view('templates/js-libs', $data);
