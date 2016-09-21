<?php defined('BASEPATH') OR exit('No direct script access allowed');

include_once(APPPATH . 'controllers/Generic.php');

class Teacher extends Generic {

    function __construct()
    {
        parent::__construct();
        $this->load->model('UsersModel');
        $this->load->library('Ion_auth');
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

    public function classesSelection()
    {
        $this->session->unset_userdata('classesId');

        $post = $this->input->post();
        
        if (array_key_exists('classesId', $post)) {
            $classesId = $post['classesId'];
            $this->session->set_userdata('classesId', $classesId);
            return true;
        }
        $classes = $this->UsersModel->getClasses();
        $classesData = [];
        foreach ($classes as $key => $class) {
            $classesData[$class['grade_number']][] = $class;
        }

        $obj = [
            'body' => $this->load->view('teacher/classes_selection', [
                'classesData' => $classesData], true),
            'csses' => [],
            'jses' => ['/js/pages/classes-selection.js'],
        ];
        $this->_render($obj);
    }

    public function classroomEvaluation()
    {
        $usersId = $this->session->userdata("user_id");
        $classesId = $this->session->userdata("classesId");
        if (!isset($usersId)) {
            redirect('/user/login','refresh');
        }
        $courses = $this->UsersModel->getCoursesByTeachersId($usersId);
        $evaluationIndexData = [];
        $evaluationDetailData = [];
        
        $defaultCoursesId = $courses[0]['id'];
        $evaluationIndexInfo = $this->UsersModel->getCourseEvaluationIndexs($defaultCoursesId);
        $evaluationIndexHtml = $this->getEvaluationIndexHtml($defaultCoursesId);

        $defaultEvaluationIndexsId = $evaluationIndexInfo[0]['id'];
        $evaluationDetailInfo = $this->UsersModel->getCourseEvaluationDetails($defaultEvaluationIndexsId);
        $evaluationDetailHtml = $this->getEvaluationDetailHtml($defaultEvaluationIndexsId);

        $selectedStudentsData = $this->UsersModel->getClassStudentsByClassesId($classesId);

        $obj = [
            'body' => $this->load->view('teacher/classroom_evaluation', [
                                        'selectedStudentsData' => $selectedStudentsData,
                                        'courses' => $courses,
                                        'defaultCoursesId' => $defaultCoursesId,
                                        'evaluationIndexInfo' => $evaluationIndexInfo,
                                        'evaluationIndexHtml' => $evaluationIndexHtml,
                                        'evaluationDetailHtml' => $evaluationDetailHtml,
                                        'evaluationDetailInfo' => $evaluationDetailInfo], true),
            'csses' => [],
            'jses' => ['/js/pages/classroom-evaluation.js'],
        ];
        $this->_render($obj);
    }

    public function submitEvaluation()
    {   
        $response = "true";
        $post = $this->input->post();
        $usersId = $this->session->userdata("user_id");
        $classesId = $this->session->userdata("classesId");
        $studentsIds = $post['studentsIds'];
        $coursesId = $post['coursesId'];
        $evaluationIndexsId = $post['evaluationIndexsId'];
        $evaluationDetailsId = $post['evaluationDetailsId'];
        $evaluationLevel = $post['evaluationLevel'];
        $evaluationData = [
                'evaluateDate' => '2016-12-12',
                'coursesId' => $coursesId,
                'evaluationIndexsId' => $evaluationIndexsId,
                'evaluationDetailsId' => $evaluationDetailsId,
                'scoresId' => $evaluationLevel,
                'teachersUsersId' => $usersId,
            ];
        foreach ($studentsIds as $studentsId) {
            $evaluationData['studentsUsersId'] = $studentsId;
            $newEvaluationId = $this->UsersModel->submitEvaluation($evaluationData);
            if (!$newEvaluationId) {
                $response = "false";
            }
        }

        echo $response;
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
                'orderNumber' => NULL,
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
                    $this->UsersModel->delEvaluationDetailByIndexId($data['id']);
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
            'jses' => ['/js/pages/course-evaluation-management.js'],
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

    public function studentsDataManagement()
    {
        $usersId = $this->session->userdata("user_id");
        if (!isset($usersId)) {
            redirect('/user/login','refresh');
        }

        if (array_key_exists('csvfile', $_FILES)) {
            $file = $_FILES['csvfile'];
        
            if ($file['size'] > 0) {
                if ($file['type'] === 'text/csv') {

                    $csv = file_get_contents($file['tmp_name']);
                    $rowList = array_map("str_getcsv", explode("\r", $csv));

                    $validNames= ['username', 'password', 'firstName', 'classesId', 'eduStartingYear', 'cityStudentNumber', 'nationalStudentNumber', 'gender', 'birthDate'];

                    $fileHeader = array_shift($rowList);
                    
                    $difference = array_diff($validNames, $fileHeader);
                    if ($difference) {
                        // var_dump($difference);die("ss");
                        // $output['error'] = 'File header is not correct! Please check these labels in first line of file: ' . implode(",", $difference);
                    } else {
                        foreach ($rowList as $key => $row) {
                            $studentData = array_combine($validNames, $row);

                            $studentsId = $this->ion_auth->register($studentData['username'], $studentData['password'], '', ['first_name' => $studentData['firstName']], [4]);
                            $studentData['usersId'] = $studentsId;
                            $evaluationDetails = $this->UsersModel->addStudentAddtionalData($studentData);
                        }
                    }
                } else {
                    // $output['error'] = 'File format is not correct!';
                }
            }
        }

        
        $obj = [
            'body' => $this->load->view('teacher/students-data-management', [], true),
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

    public function ajaxGetCourseEvaluateContent()
    {
        $post = $this->input->post();
        $coursesId = $post['coursesId'];

        $evaluationIndexHtml = $this->getEvaluationIndexHtml($coursesId);

        $evaluationIndexInfo = $this->UsersModel->getCourseEvaluationIndexs($coursesId);
        $evaluationIndexsId = $evaluationIndexInfo[0]['id'];
        $evaluationDetailHtml = $this->getEvaluationDetailHtml($evaluationIndexsId);

        $response = ['evaluationIndexHtmlContent' => $evaluationIndexHtml, 'evaluationDetailHtmlContent' => $evaluationDetailHtml];

        echo json_encode($response);
    }

    public function ajaxGetIndexEvaluateContent()
    {
        $post = $this->input->post();
        $evaluationIndexsId = $post['evaluationIndexsId'];

        $evaluationDetailHtml = $this->getEvaluationDetailHtml($evaluationIndexsId);
        echo $evaluationDetailHtml;
    }

    public function getEvaluationIndexHtml($coursesId)
    {
        $evaluationIndexInfo = $this->UsersModel->getCourseEvaluationIndexs($coursesId);
        $evaluationIndexHtml = "<div class='btn-group' id='evaluation-index-btn-group' name='evaluation-index-btn-group' data-toggle='buttons'>";
        $evaluationIndexActive = "active";
        foreach ($evaluationIndexInfo as $key => $evaluationIndex) {
          $evaluationIndexHtml = $evaluationIndexHtml . "<label class='btn btn-default " .$evaluationIndexActive. "''><input type='radio' id='" . $evaluationIndex['id'] . "'>" . $evaluationIndex['description'] . "</label>";
          $evaluationIndexActive = "";
        }
        $evaluationIndexHtml = $evaluationIndexHtml . "</div>";

        return $evaluationIndexHtml;
    }

    public function getEvaluationDetailHtml($evaluationIndexsId)
    {
        $evaluationDetailInfo = $this->UsersModel->getCourseEvaluationDetails($evaluationIndexsId);
        $evaluationDetailHtml = "<div class='btn-group' id='evaluation-detail-btn-group' name='evaluation-detail-btn-group' data-toggle='buttons'>";
        $evaluationDetailActive = "active";
        foreach ($evaluationDetailInfo as $key => $evaluationDetail) {
          $evaluationDetailHtml = $evaluationDetailHtml . "<label class='btn btn-default " .$evaluationDetailActive. "'><input type='radio' id='" . $evaluationDetail['id'] . "'>" . $evaluationDetail['description'] . "</label>";
          $evaluationDetailActive = "";
        }
        $evaluationDetailHtml = $evaluationDetailHtml . "</div>";

        return $evaluationDetailHtml;
    }
}
