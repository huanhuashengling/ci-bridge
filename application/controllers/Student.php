<?php defined('BASEPATH') OR exit('No direct script access allowed');

include_once(APPPATH . 'controllers/Generic.php');

class Student extends Generic {

    function __construct()
    {
        parent::__construct();
        $this->_checkLogin();
        $this->load->model('UsersModel');
        $this->load->library('Ion_auth');
    }

    public function _checkLogin()
    {
        $usersId = $this->session->userdata("user_id");
        if (!isset($usersId)) {
            redirect('/user/login','refresh');
        }
    }

    function index()
    {
        $params = $this->_getParams();
        $obj = [
            'body' => $this->load->view('student/index', [], true),
            'csses' => [],
            'jses' => [],
            'header' => $this->load->view('student/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function starSwallow()
    {
        $evaluationData = [];

        $usersId = $this->session->userdata("user_id");
        $courses = $this->UsersModel->getCourses();
        $evaludateCount = $this->UsersModel->getEvaluateCountByStudentsId();

        $params = $this->_getParams();
        $obj = [
            'body' => $this->load->view('student/star_swallow', [], true),
            'csses' => [],
            'jses' => [],
            'header' => $this->load->view('student/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function getCourseCountItemHtml()
    {
        $courseCountItemHtml = "<table class='table table-striped table-hover table-condensed'><tr><td>语文</td></tr></table>";


        return $courseCountItemHtml;
    }

}
