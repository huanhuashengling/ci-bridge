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

        $evaluateCountHtml = [];
        foreach ($courses as $key => $course) {

            $evaluateCount = $this->UsersModel->getEvaluateCountByStudentsId($usersId, $course['id']);
            if (0 == count($evaluateCount)) {

                $evaluateItem = [
                    'course_name' => $course['name'],
                    'courses_id' => $course['id'],
                    'star_name' => $course['star_name'],
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
        $starName = ("" != $evaluateItem['star_name'])?"(" . $evaluateItem['star_name'] . ")":"";
        $courseCountItemHtml = "<div class='col-md-4 col-sm-4'><table class='table table-bordered table-hover table-condensed' value='" . $evaluateItem["courses_id"]. "'><tr><td colspan=2 class='text-center'><h4>". $evaluateItem['course_name'] . "<small> ". $starName ."</small></h4></td></tr><tr ><td width='50%'><h5>评价次数</h5></td><td><h5>". $evaluateItem['evaluate_count'] . "</h5></td></tr><tr><td><h5>得分</h5></td><td><h5>". $evaluateItem['score'] . "</h5></td></tr></table></div>";

        return $courseCountItemHtml;
    }

    public function evaluateDetail()
    {
        $coursesId = $this->uri->segment(3);
        $usersId = $this->session->userdata("user_id");
        $params = $this->_getParams();
        $course = $this->UsersModel->getOneCourse($coursesId);
        $obj = [
            'body' => $this->load->view('student/evaluate_detail', 
                                    ['coursesId' => $coursesId,
                                    'usersId' => $usersId,
                                    'coursesName' => $course["name"],
                                    ], true),
            'csses' => ['/css/bootstrap-table.css'],
            'jses' => ['/js/pages/evaluate-detail.js',
                        '/js/bootstrap-table.js',
                        '/js/locale/bootstrap-table-zh-CN.js'],
            'header' => $this->load->view('student/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function getStudentEvaluateDetail()
    {
        $post = $this->input->post();
        
        $evaluateDetail = $this->UsersModel->getEvaluateDetailByStudentsId($post["usersId"], $post["coursesId"]);

        echo json_encode($evaluateDetail);
    }
}
