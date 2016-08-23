<?php defined('BASEPATH') OR exit('No direct script access allowed');

include_once(APPPATH . 'controllers/Generic.php');

class Teacher extends Generic {

    function __construct()
    {
        parent::__construct();
        $this->load->model('UsersModel');
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
        $usersId = $this->session->userdata("user_id");
        $teachersInfo = $this->UsersModel->getTeachersInfoByUsersId($usersId);
        $courseName = "";
        $courseEvaluationInfo = [];
        if (isset($teachersInfo['course_leader'])) {
            $course = $this->UsersModel->getOneCourse($teachersInfo['course_leader']);
            $courseName = $course['name'];
            $evaluationIndexs = $this->UsersModel->getCourseEvaluationIndexs($teachersInfo['course_leader']);
            foreach ($evaluationIndexs as $key => $evaluationIndex) {
                $courseEvaluationInfo[$evaluationIndex['id']] = $evaluationIndex;
                $evaluationDetails = $this->UsersModel->getCourseEvaluationDetails($evaluationIndex['id']);
                $courseEvaluationInfo[$evaluationIndex['id']]['details'] = $evaluationDetails;
            }
            // var_dump($courseEvaluationInfo);
        }
        $obj = [
            'body' => $this->load->view('teacher/course_evaluation_management', ['courseName' => $courseName, 'courseEvaluationInfo' => $courseEvaluationInfo], true),
            'csses' => [],
            'jses' => [],
        ];
        $this->_render($obj);
    }

    public function classStudentInfo()
    {
        $obj = [
            'body' => $this->load->view('teacher/class_student_info', [], true),
            'csses' => [],
            'jses' => [],
        ];
        $this->_render($obj);
    }

    public function classEvaluationCount()
    {
        $obj = [
            'body' => $this->load->view('teacher/class_evaluation_count', [], true),
            'csses' => [],
            'jses' => [],
        ];
        $this->_render($obj);
    }
}
