<?php defined('BASEPATH') OR exit('No direct script access allowed');

include_once(APPPATH . 'controllers/Generic.php');

class Teacher extends Generic
{
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
            'body' => $this->load->view('teacher/index', [], true),
            'csses' => [],
            'jses' => [],
            'header' => $this->load->view('teacher/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function loadCommentArea()
    {
        $this->session->unset_userdata('classesId');

        $post = $this->input->post();
        
        if (array_key_exists('classesId', $post)) {
            $classesId = $post['classesId'];
            $this->session->set_userdata('classesId', $classesId);

            $studentsHtml = $this->getStudentsHtml($classesId);
            
            $usersId = $this->session->userdata("user_id");
            $courseHtml = $this->getCourseHtml($usersId);
            // $courses = $this->UsersModel->getCoursesByTeachersId($usersId);
            $courses = $this->UsersModel->getCourses();

            $evaluationIndexHtml = $this->getEvaluationIndexHtml($courses[0]['id']);
            
            $evaluationIndexInfo = $this->UsersModel->getCourseEvaluationIndexs($courses[0]['id']);

            $evaluationDetailHtml = $this->getEvaluationDetailHtml($evaluationIndexInfo[0]['id']);

            $response = ['courseHtml' => $courseHtml, 'studentsHtml' => $studentsHtml, 'evaluationIndexHtmlContent' => $evaluationIndexHtml, 'evaluationDetailHtmlContent' => $evaluationDetailHtml];

            echo json_encode($response);
        }
    }

    public function classroomEvaluation($isResetClass = NULL)
    {
        $usersId = $this->session->userdata("user_id");
        $user = $this->UsersModel->getTeachersInfoByUsersId($usersId);

        if (isset($isResetClass) && "reset" == $isResetClass) {
            $this->session->unset_userdata("classesId");
        } else {
            $classesId = $this->session->unset_userdata("classesId");
        }
        $selectedStudentsData = [];
        $hideClassSelection = "";
        if (isset($classesId)) {
            $hideClassSelection = "hidden";
            $selectedStudentsData = $this->UsersModel->getClassStudentsByClassesId($classesId);
        }

        $classes = $this->UsersModel->getClasses();
        $classesData = [];
        foreach ($classes as $key => $class) {
            $classesData[$class['grade_number']][] = $class;
        }

        // $courses = $this->UsersModel->getCoursesByTeachersId($usersId);
        $courses = $this->UsersModel->getCourses();
        $evaluationIndexData = [];
        $evaluationDetailData = [];
        
        $defaultCoursesId = $courses[0]['id'];
        $evaluationIndexInfo = $this->UsersModel->getCourseEvaluationIndexs($defaultCoursesId);
        $evaluationIndexHtml = $this->getEvaluationIndexHtml($defaultCoursesId);

        $defaultEvaluationIndexsId = $evaluationIndexInfo[0]['id'];
        $evaluationDetailInfo = $this->UsersModel->getCourseEvaluationDetails($defaultEvaluationIndexsId);
        $evaluationDetailHtml = $this->getEvaluationDetailHtml($defaultEvaluationIndexsId);
        $params = $this->_getParams();
        $params['courseLeader'] = $user['course_leader'];
        $params['classTeacher'] = $user['class_teacher'];
        $obj = [
            'body' => $this->load->view('teacher/classroom_evaluation', [
                                        'classesData' => $classesData,
                                        'hideClassSelection' => $hideClassSelection,
                                        'selectedStudentsData' => $selectedStudentsData,
                                        'courses' => $courses,
                                        'defaultCoursesId' => $defaultCoursesId,
                                        'evaluationIndexInfo' => $evaluationIndexInfo,
                                        'evaluationIndexHtml' => $evaluationIndexHtml,
                                        'evaluationDetailHtml' => $evaluationDetailHtml,
                                        'evaluationDetailInfo' => $evaluationDetailInfo], true),
            'csses' => [],
            'jses' => ['/js/pages/classroom-evaluation.js'],
            'header' => $this->load->view('teacher/header', $params, true),
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
                'evaluateDate' => date("Y-m-d h:i:s"),
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
        $user = $this->UsersModel->getTeachersInfoByUsersId($usersId);

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
        
        $params = $this->_getParams();
        $params['courseLeader'] = $user['course_leader'];
        $params['classTeacher'] = $user['class_teacher'];
        $obj = [
            'body' => $this->load->view('teacher/course_evaluation_management', 
                $data, true),
            'csses' => [],
            'jses' => ['/js/pages/course-evaluation-management.js'],
            'header' => $this->load->view('teacher/header', $params, true),
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
        $usersId = $this->session->userdata("user_id");
        $user = $this->UsersModel->getTeachersInfoByUsersId($usersId);

        $studentsData = $this->UsersModel->getClassStudentsByClassesId($user['class_teacher']);
        $params = $this->_getParams();
        $params['courseLeader'] = $user['course_leader'];
        $params['classTeacher'] = $user['class_teacher'];
        $obj = [
            'body' => $this->load->view('teacher/class_student_info', ['studentsData' => $studentsData, 'classesId'=>$user['class_teacher']], true),
            'csses' => [],
            'jses' => ['/js/pages/class-student-info.js'],
            'header' => $this->load->view('teacher/header', $params, true),
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

    public function evaluationHistory()
    {
        $usersId = $this->session->userdata("user_id");
        $user = $this->UsersModel->getTeachersInfoByUsersId($usersId);

        $evaluationData = $this->UsersModel->getTeacherEvaluationData($usersId);

        $params = $this->_getParams();
        $params['courseLeader'] = $user['course_leader'];
        $params['classTeacher'] = $user['class_teacher'];
        $obj = [
            'body' => $this->load->view('teacher/evaluation_history', ['evaluationData' => $evaluationData], true),
            'csses' => [],
            'jses' => ['/js/pages/evaluation-history.js'],
            'header' => $this->load->view('teacher/header', $params, true),
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

    public function ajaxDeleteEvaluateItem()
    {
        $post = $this->input->post();
        return $this->UsersModel->deleteEvaluateItem($post['evaluationId']);
    }

    public function ajaxAddStudent()
    {
        $post = $this->input->post();
        $studentData = [
            'username' => $post['studentName'],
            'password' => '123456',
            'firstName' => $post['studentName'],
            'classesId' => $post['classesId'],
            'eduStartingYear' => '',
            'cityStudentNumber' => '',
            'nationalStudentNumber' => '',
            'gender' => $post['studentGender'],
            'birthDate' => '',
        ];

        $studentsId = $this->ion_auth->register($studentData['username'], $studentData['password'], '', ['first_name' => $studentData['firstName']], [4]);
        $studentData['usersId'] = $studentsId;
        $student = $this->UsersModel->addStudentAddtionalData($studentData);

        if ($studentsId && $student) {
            return true;
        } else {
            return false;
        }
    }

    public function getIndexEvaluateContent()
    {
        $post = $this->input->post();
        $evaluationIndexsId = $post['evaluationIndexsId'];

        $evaluationDetailHtml = $this->getEvaluationDetailHtml($evaluationIndexsId);
        echo $evaluationDetailHtml;
    }

    public function getStudentsHtml($classesId)
    {
        $selectedStudentsData = $this->UsersModel->getClassStudentsByClassesId($classesId);

        $maxNumPerLine = 4;
            $num = 0;
        $studentsHtml = "<div><a class='btn btn-primary' href='/teacher/classroom-evaluation'>返回班级选择</a></div>";
        $studentsHtml =  $studentsHtml . "<table class='table table-striped table-hover table-condensed'><tr>";
            
            foreach ($selectedStudentsData as $key => $student) {
              $btnClass = (0 == $student['gender'])?"btn-danger":"btn-primary";
              $gender = (0 == $student['gender'])?"gender='girl'":"gender='boy'";
              if ($num < $maxNumPerLine) {
                $num++;
                $studentsHtml =  $studentsHtml . "<td><button class='btn " . $btnClass . " student-btn' " . $gender . " value='" . $student['id'] . "'>" . $student['username'] . "</button></td>";
              } else {
                $num = 0;
                $studentsHtml =  $studentsHtml . "<td><button class='btn " . $btnClass . " student-btn' " . $gender . " value='" . $student['id'] . "'>" . $student['username'] . "</button></td></tr><tr>";
              }
                    
            }
            $studentsHtml =  $studentsHtml . "</tr></table>";

        return $studentsHtml;
    }

    public function getCourseHtml($usersId)
    {
        // $courses = $this->UsersModel->getCoursesByTeachersId($usersId);
        $courses = $this->UsersModel->getCourses();

        $courseHtml = "<div class='btn-group' id='course-btn-group' name='course-btn-group' data-toggle='buttons'>";
        $courseActive = "active";
        foreach ($courses as $key => $course) {
          $courseHtml = $courseHtml . "<label class='btn btn-default " .$courseActive. "'><input type='radio' id='" . $course['id'] . "'>" . $course['name'] . "</label>";
          $courseActive = "";
        }
        $courseHtml = $courseHtml . "</div>";
        return $courseHtml;
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
