<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH . 'controllers/Generic.php');
class Teacher extends Generic {

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $obj = [
            'body' => $this->load->view('teacher/index', [], true),
            'csses' => [],
            'jses' => [],
        ];
        $this->_render($obj);
    }

    public function classroomEvaluation()
    {
        $obj = [
            'body' => $this->load->view('teacher/classroom_evaluation', [], true),
            'csses' => [],
            'jses' => [],
        ];
        $this->_render($obj);
    }

    public function courseEvaluationManagement()
    {
        var_dump($_SESSION);
        $obj = [
            'body' => $this->load->view('teacher/course_evaluation_management', [], true),
            'csses' => [],
            'jses' => [],
        ];
        $this->_render($obj);
    }
}
