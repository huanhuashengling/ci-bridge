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
        $evaluateCount = $this->UsersModel->getEvaluateCountByStudentsId($usersId);
        $evaluateCountHtml = [];
        foreach ($evaluateCount as $key => $evaluateItem) {
            $evaluateCountHtml[] = $this->getCourseCountItemHtml($evaluateItem);
        }
        $params = $this->_getParams();
        $obj = [
            'body' => $this->load->view('student/star_swallow', ['evaluateCountHtml' => $evaluateCountHtml], true),
            'csses' => [],
            'jses' => [],
            'header' => $this->load->view('student/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function getCourseCountItemHtml($evaluateItem)
    {
        $courseCountItemHtml = "<div class='col-md-4 col-sm-4'><table class='table table-bordered table-hover table-condensed'><tr><td colspan=2>". $evaluateItem['course_name'] . "</td></tr><tr><td>评价次数</td><td>". $evaluateItem['evaluate_count'] . "</td></tr><tr><td>分数合计</td><td>". $evaluateItem['score'] . "</td></tr></table></div>";

        return $courseCountItemHtml;
    }

}
