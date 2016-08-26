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
        if (!isset($usersId)) {
            redirect('/user/login','refresh');
        }

        $currentOperate = $this->input->post("currentOperate", true);
        if (isset($currentOperate)) {
            $data = [
                'coursesId' => $this->input->post("coursesId", true),
                'lastUpdatedBy' => $this->session->userdata("username"),
                'lastUpdateDate' => date("Y-m-d"),
                'orderNumber' => 5,
            ];
            // echo $currentOperate;die();
            switch ($currentOperate)
            {
                case "add-index":
                    $data['description'] = $this->input->post("indexDescription", true);
                    $this->UsersModel->addEvaluationIndex($data);
                break;
                case "edit-index":
                    $data['id'] = $this->input->post("indexId", true);
                    $data['description'] = $this->input->post("indexDescription", true);
                    $this->UsersModel->editEvaluationIndex($data);
                break;
                case "del-index":
                    $data['id'] = $this->input->post("indexId", true);
                    $this->UsersModel->delEvaluationIndex($data);
                break;
                case "add-detail":
                    $data['description'] = $this->input->post("detailDescription", true);
                    $data['evaluationIndexsId'] = $this->input->post("indexId", true);
                    $this->UsersModel->addEvaluationDetail($data);
                break;
                case "edit-detail":
                    $data['id'] = $this->input->post("detailId", true);
                    $data['description'] = $this->input->post("detailDescription", true);
                    $this->UsersModel->editEvaluationDetail($data);
                break;
                case "del-detail":
                    $data['id'] = $this->input->post("detailId", true);
                    $this->UsersModel->delEvaluationDetail($data);
                break;
            }
            $data = $this->getEvaluationInfo($usersId);
            return $this->load->view('teacher/course_evaluation_management', $data, false);
        }
        

        $data = $this->getEvaluationInfo($usersId);
        $obj = [
            'body' => $this->load->view('teacher/course_evaluation_management', 
                $data, true),
            'csses' => [],
            'jses' => ['/js/pages/course_evaluation_management.js'],
        ];
        $this->_render($obj);
    }

    public function getEvaluationInfo($usersId)
    {
        $teachersInfo = $this->UsersModel->getTeachersInfoByUsersId($usersId);
        $course = [];
        $courseEvaluationInfo = [];
        if (isset($teachersInfo['course_leader'])) {
            $course = $this->UsersModel->getOneCourse($teachersInfo['course_leader']);
            $evaluationIndexs = $this->UsersModel->getCourseEvaluationIndexs($teachersInfo['course_leader']);
            foreach ($evaluationIndexs as $key => $evaluationIndex) {
                $courseEvaluationInfo[$evaluationIndex['id']] = $evaluationIndex;
                $evaluationDetails = $this->UsersModel->getCourseEvaluationDetails($evaluationIndex['id']);
                $courseEvaluationInfo[$evaluationIndex['id']]['details'] = $evaluationDetails;
            }
            // var_dump($courseEvaluationInfo);
        }

        return ['course' => $course, 
                'courseEvaluationInfo' => $courseEvaluationInfo];
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
