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
        // var_dump($courses);
        $evaluateCountHtml = [];
        foreach ($courses as $key => $course) {
            $evaluateCount = $this->UsersModel->getEvaluateCountByStudentsId($usersId, $course['id']);
            if (0 == count($evaluateCount)) {
                $evaluateItem = [
                    'course_name' => $course['name'],
                    'courses_id' => $course['id'],
                    'evaluate_count' => 0,
                    'score' => 0,
                ];
            } else {
                $evaluateItem = $evaluateCount[0];
            }
            $evaluateCountHtml[] = $this->getCourseCountItemHtml($evaluateItem);
        }
        $params = $this->_getParams();
        $obj = [
            'body' => $this->load->view('student/star_swallow', ['evaluateCountHtml' => $evaluateCountHtml], true),
            'csses' => [],
            'jses' => ['/js/pages/star-swallow.js'],
            'header' => $this->load->view('student/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function getCourseCountItemHtml($evaluateItem)
    {
        $courseCountItemHtml = "<div class='col-md-4 col-sm-4'><table class='table table-bordered table-hover table-condensed' value=1><tr><td colspan=2>". $evaluateItem['course_name'] . "</td></tr><tr ><td width='50%'>评价次数</td><td>". $evaluateItem['evaluate_count'] . "</td></tr><tr><td>分数合计</td><td>". $evaluateItem['score'] . "</td></tr></table></div>";

        return $courseCountItemHtml;
    }

}
