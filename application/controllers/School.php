<?php defined('BASEPATH') OR exit('No direct script access allowed');

include_once(APPPATH . 'controllers/Generic.php');

class School extends Generic
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

        $params = $this->_getParams();
        $obj = [
            'body' => $this->load->view('school/students-data-management', [], true),
            'csses' => [],
            'jses' => [],
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

        $params = $this->_getParams();
        $obj = [
            'body' => $this->load->view('school/teachers-data-management', [], true),
            'csses' => [],
            'jses' => [],
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
        $params = $this->_getParams();
        $obj = [
            'body' => $this->load->view('school/teacher_evaluation_count', [], true),
            'csses' => [],
            'jses' => [],
            'header' => $this->load->view('school/header', $params, true),
        ];
        $this->_render($obj);
    }
}
