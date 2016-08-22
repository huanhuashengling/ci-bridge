<?php defined('BASEPATH') OR exit('No direct script access allowed');

include_once(APPPATH . 'controllers/Generic.php');

class School extends Generic {

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->load->view('school/index');
        $obj = [
            'body' => $this->load->view('school/index', [], true),
            'csses' => [],
            'jses' => [],
        ];
        $this->_render($obj);
    }

    public function schoolEvaluationCount()
    {
        $obj = [
            'body' => $this->load->view('school/school_evaluation_count', [], true),
            'csses' => [],
            'jses' => [],
        ];
        $this->_render($obj);
    }

    public function gradeEvaluationCount()
    {
        $obj = [
            'body' => $this->load->view('school/grade_evaluation_count', [], true),
            'csses' => [],
            'jses' => [],
        ];
        $this->_render($obj);
    }
}
