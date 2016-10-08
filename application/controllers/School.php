<?php defined('BASEPATH') OR exit('No direct script access allowed');

include_once(APPPATH . 'controllers/Generic.php');

class School extends Generic
{

    function __construct()
    {
        parent::__construct();
        $this->_checkLogin();
        $this->load->model('UsersModel');
        $this->load->model('ion_auth_model');
        $this->load->library('Ion_auth');
    }
    
    public function _checkLogin()
    {
        $usersId = $this->session->userdata("user_id");
        if (!isset($usersId)) {
            redirect('/user/login','refresh');
        }
    }

    public function index()
    {
        $this->load->view('school/index');
        $params = $this->_getParams();
        $obj = [
            'body' => $this->load->view('school/index', [], true),
            'csses' => [],
            'jses' => [],
            'header' => $this->load->view('school/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function studentsDataManagement()
    {
        if (array_key_exists('csvfile', $_FILES)) {
            $file = $_FILES['csvfile'];
        
            if ($file['size'] > 0) {
                if ($file['type'] === 'text/csv') {

                    $csv = file_get_contents($file['tmp_name']);
                    $rowList = array_map("str_getcsv", explode("\r", $csv));

                    $validNames= ['order', 'username', 'password', 'firstName', 'classesId', 'eduStartingYear', 'cityStudentNumber', 'nationalStudentNumber', 'gender', 'birthDate'];

                    $fileHeader = array_shift($rowList);
                    
                    $difference = array_diff($validNames, $fileHeader);
                    if ($difference) {
                        // var_dump($difference);die("ss");
                        // $output['error'] = 'File header is not correct! Please check these labels in first line of file: ' . implode(",", $difference);
                    } else {
                        foreach ($rowList as $key => $row) {
                            $studentData = array_combine($validNames, $row);
// var_dump($studentData);die("ss");
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

        $classes = $this->UsersModel->getClasses();


        $params = $this->_getParams();
        $obj = [
            'body' => $this->load->view('school/students-data-management', ['classes' => $classes], true),
            'csses' => [],
            'jses' => ['/js/pages/students-data-management.js', '/js/pages/class-student-info.js'],
            'header' => $this->load->view('school/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function teachersDataManagement()
    {
        if (array_key_exists('csvfile', $_FILES)) {
            $file = $_FILES['csvfile'];
        
            if ($file['size'] > 0) {
                if ($file['type'] === 'text/csv') {
                    $csv = file_get_contents($file['tmp_name']);
                    // var_dump($csv);
                    // $rowList = array_map("str_getcsv", explode("\r", $csv));
                    $rowList = array_map("str_getcsv", explode("\r", $csv));
                    // var_dump($rowList);die("ss");
                    $validNames= ['order', 'username', 'password', 'firstName', 'courseLeader', 'classTeacher'];

                    $fileHeader = array_shift($rowList);
                    
                    $difference = array_diff($validNames, $fileHeader);
                    // var_dump($difference);
                    // die("asasas");
                    if ($difference) {
                        // var_dump($difference);die("ss");
                        // $output['error'] = 'File header is not correct! Please check these labels in first line of file: ' . implode(",", $difference);
                    } else {
                        foreach ($rowList as $key => $row) {
                            // var_dump($row);
                            $studentData = array_combine($validNames, $row);
                            // var_dump($studentData);die();
                            $studentsId = $this->ion_auth->register($studentData['username'], $studentData['password'], '', ['first_name' => $studentData['firstName']], [3]);
                            $studentData['usersId'] = $studentsId;
                            $evaluationDetails = $this->UsersModel->addTeacherAddtionalData($studentData);
                        }
                    }
                } else {
                    // $output['error'] = 'File format is not correct!';
                }
            }
        }

        $teachers = $this->UsersModel->getAllTeachers();
// var_dump($teachers);

        $params = $this->_getParams();
        $obj = [
            'body' => $this->load->view('school/teachers-data-management', ['teachers' => $teachers], true),
            'csses' => [],
            'jses' => ['/js/pages/teacher-data-management.js'],
            'header' => $this->load->view('school/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function deleteStudentsData()
    {
        $response = "";
        $evaluationDetails = $this->UsersModel->deleteAllStudentsData();

        echo json_encode($response);
    }

    public function schoolEvaluationCount()
    {
        $params = $this->_getParams();
        $obj = [
            'body' => $this->load->view('school/school_evaluation_count', [], true),
            'csses' => [],
            'jses' => [],
            'header' => $this->load->view('school/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function teacherEvaluationCount()
    {
        $teachers = $this->UsersModel->getAllTeachers();
        $teachersEvaluationData = [];
        foreach ($teachers as $key => $teacher) {
            $teacherEvaluationData = $this->UsersModel->getTeacherEvaluationData($teacher['id']);

            $teachersEvaluationData[] = [
                'username' => $teacher['username'],
                'totalCount' => count($teacherEvaluationData),
            ];
        }
        

        $params = $this->_getParams();
        $obj = [
            'body' => $this->load->view('school/teacher_evaluation_count', ['teachersEvaluationData' => $teachersEvaluationData], true),
            'csses' => [],
            'jses' => [],
            'header' => $this->load->view('school/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function ajaxResetTeacherPassword()
    {
        $post = $this->input->post();
        $teacher = $this->UsersModel->getTeachersInfoByUsersId($post['teachersId']);
        // var_dump($teacher);die();
        $success = $this->ion_auth_model->reset_password($teacher['username'], '123456');
        if ($success) {
            echo "true";
        } else {
            echo "false";
        }

    }

    public function ajaxUpdateTeacherInfo()
    {
        $post = $this->input->post();
        $course = $this->UsersModel->getCourseByName($post['courseLeader']);
        $class = $this->UsersModel->getClassByName($post['classTeacher']);

        $success = $this->UsersModel->updateTeachersInfo($post['teachersId'], $course['id'], $class['id']);
        if ($success) {
            echo "true";
        } else {
            echo "false";
        }

    }

    public function ajaxGetStudentsList()
    {
        $post = $this->input->post();
        $studentsData = $this->UsersModel->getClassStudentsByClassesId($post['classesId']);
        echo $this->load->view('teacher/class_student_info', ['classesId' => $post['classesId'], 'studentsData' => $studentsData, 'enableDelete' => ''], true);
    }
}
