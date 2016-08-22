<?php defined('BASEPATH') OR exit('No direct script access allowed');

include_once(APPPATH . 'controllers/Generic.php');

class Admin extends Generic {

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $obj = [
            'body' => $this->load->view('/admin/index', [], true),
            'csses' => [],
            'jses' => [],
        ];
        $this->_render($obj);
    }

}
