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
        $this->load->helper('download');
        $this->load->library('pinyinfirstchar');
    }
    
    public function _checkLogin()
    {
        // echo $_SERVER['REQUEST_URI'];die();
        
        $usersId = $this->session->userdata("user_id");
        //Just for search the count
        if ("/school/class-evaluation-count" == $_SERVER['REQUEST_URI'] || "/school/ajax-get-class-evaluation-count" == $_SERVER['REQUEST_URI']){

        } elseif (!isset($usersId)) {
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
                            $teacherData = array_combine($validNames, $row);
                            // var_dump($teacherData);die();
                            $teachersId = $this->ion_auth->register($teacherData['username'], $teacherData['password'], '', ['first_name' => $teacherData['firstName']], [3]);
                            $teacherData['usersId'] = $teachersId;
                            $evaluationDetails = $this->UsersModel->addTeacherAddtionalData($teacherData);
                        }
                    }
                } else {
                    // $output['error'] = 'File format is not correct!';
                }
            }
        }

        $allCourses = $this->UsersModel->getCourses();
        $allClasses = $this->UsersModel->getClasses();
        $teachers = $this->UsersModel->getAllTeachers();
        $teacherCourses = [];
        foreach ($teachers as $key => $teacher) {
            $courses = $this->UsersModel->getCoursesByTeachersId($teacher['id']);
            $teacherCoursesId[$teacher['id']] = implode(",", array_column($courses, 'id'));
            $teacherCoursesName[$teacher['id']] = implode(",", array_column($courses, 'name'));
        }

        $params = $this->_getParams();
        $obj = [
            'body' => $this->load->view('school/teachers-data-management', 
                                        ['teachers' => $teachers, 
                                        'teacherCoursesId' => $teacherCoursesId, 
                                        'teacherCoursesName' => $teacherCoursesName, 
                                        'allCourses' => $allCourses, 
                                        'allClasses' => $allClasses], true),
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
        $params = $this->_getParams();
        $obj = [
            'body' => $this->load->view('school/teacher_evaluation_count', [], true),
            'csses' => [],
            'jses' => ['/js/pages/teacher-evaluation-count.js'],
            'header' => $this->load->view('school/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function classEvaluationCount()
    {
        $params = $this->_getParams();
        $courses = $this->UsersModel->getCourses();
        $classes = $this->UsersModel->getClasses();
        $classesData = [];
        foreach ($classes as $key => $class) {
            $classesData[$class['grade_number']][] = $class;
        }

        $obj = [
            'body' => $this->load->view('school/class_evaluation_count', ["courses" => $courses, "classesData" => $classesData], true),
            'csses' => [],
            'jses' => ['/js/pages/class-evaluation-count.js'],
            'header' => $this->load->view('school/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function ajaxResetTeacherPassword()
    {
        $post = $this->input->post();
        $teacher = $this->UsersModel->getTeachersInfoByUsersId($post['teachersId']);
        $success = $this->ion_auth_model->reset_password($teacher['username'], '123456');
        if ($success) {
            echo "true";
        } else {
            echo "false";
        }

    }

    public function ajaxAddTeacher()
    {
        $post = $this->input->post();
                            
        $teacherData = [
            'username' => $post['teacherName'],
            'password' => '123456',
            'firstName' => $post['teacherName'],
            'courseLeader' => $post['courseLeader'],
            'classTeacher' => $post['classTeacher'],
            // 'teacherCourse' => $post['teacherCourse'],
        ];

        $teachersId = $this->ion_auth->register($teacherData['username'], $teacherData['password'], '', ['first_name' => $teacherData['firstName']], [3]);
        $teacherData['usersId'] = $teachersId;
        $teacherAddtional = $this->UsersModel->addTeacherAddtionalData($teacherData);

        if (count($post['teacherCourse']) > 0) {
            $success = $this->UsersModel->deleteCoursesTeachersByTeachersId($teachersId);
            if ($success) {
                foreach ($post['teacherCourse'] as $coursesId) {
                    $success = $this->UsersModel->addCoursesTeachers($teachersId, $coursesId);
                }
            }
        }

        if ($success) {
            echo "true";
        } else {
            echo "false";
        }
    }

    public function ajaxUpdateTeacherInfo()
    {
        $post = $this->input->post();
        $teacherCourse = $post['teacherCourse'];

        $success = $this->UsersModel->updateTeachersInfo($post['teachersId'], $post['courseLeader'], $post['classTeacher']);
        if (count($post['teacherCourse']) > 0) {
            $success = $this->UsersModel->deleteCoursesTeachersByTeachersId($post['teachersId']);
            if ($success) {
                foreach ($post['teacherCourse'] as $coursesId) {
                    $success = $this->UsersModel->addCoursesTeachers($post['teachersId'], $coursesId);
                }
            }
        }
        
        if ($success) {
            echo "true";
        } else {
            echo "false";
        }

    }

    public function ajaxGetStudentsList()
    {
        $post = $this->input->post();
        $showInactive = ("true" == $post['showInactive'])?true:false;
        $studentsData = $this->UsersModel->getClassStudentsByClassesId($post['classesId'], $showInactive);

        echo $this->load->view('teacher/class_student_info', ['classesId' => $post['classesId'], 'studentsData' => $studentsData, 'enableDelete' => ''], true);
    }

    public function ajaxGetTeacherEvaluationCount()
    {
        $startWeeNum = 6;
        $totalCount = 0;
        $post = $this->input->post();
        $teachersEvaluationData = [];
        if ("" != $post['weekNum']) {
            $weekNum = (0 == $post['weekNum'])?null:($post['weekNum'] + $startWeeNum);
            $teachers = $this->UsersModel->getAllTeachers();
            foreach ($teachers as $key => $teacher) {
                $teacherEvaluationData = $this->UsersModel->getTeacherEvaluationData($teacher['id'], $weekNum);

                $teachersEvaluationData[] = [
                    'username' => $teacher['username'],
                    'totalCount' => count($teacherEvaluationData),
                ];

                $totalCount += count($teacherEvaluationData);
            }
            if ("true" == $post['export']) {
                $this->exportTeacherEvaluationData($teachersEvaluationData);
            } else {
                echo $this->load->view('school/partial/teacher_evaluation_list', ['teachersEvaluationData' => $teachersEvaluationData, 'totalCount' => $totalCount], true);
            }
        }
    }

    public function ajaxGetClassEvaluationCount()
    {
        $post = $this->input->post();
        $selectCourses = [];
        if (isset($post['coursesId'])) {
            $coursesId = $post['coursesId'];
            $selectCourses[] = $this->UsersModel->getOneCourse($coursesId);
        } else {
            $coursesId = NULL;
            $selectCourses = $this->UsersModel->getCourses();
        }
        $class = $this->UsersModel->getOneClasses($post['classesId']);
        $classEvaluationData = [];
        $students = $this->UsersModel->getClassStudentsByClassesId($post['classesId']);
        $totalCount = 0;
        $totalScore = 0;
        foreach ($students as $key => $student) {
            $studentEvaluationData = $this->UsersModel->getEvaluateCountByStudentsId($student['users_id'], $coursesId);
            $classEvaluationitem = ['num' => ($key + 1), 'username' => "<small>".$this->pinyinfirstchar->getFirstchar($student['username'])."</small> ".$student['username']];
            // var_dump($student);die();
            $studentCount = 0;
            $studentScore = 0;
            if (count($studentEvaluationData) > 0) {
                $data = [];
                foreach ($studentEvaluationData as $key => $studentEvaluationItem) {
                    $data[$studentEvaluationItem['courses_id']] = $studentEvaluationItem;
                }
                $studentEvaluationData = $data;
                // var_dump($studentEvaluationData);die();
                
                foreach ($selectCourses as $key => $course) {
                    if (isset($studentEvaluationData[$course['id']])) {
                        $item = $studentEvaluationData[$course['id']];

                        $totalCount += $item['evaluate_count'];
                        $totalScore += $item['score'];

                        $studentCount += $item['evaluate_count'];
                        $studentScore += $item['score'];

                        

                        $classEvaluationitem[$course['name']] = $item['evaluate_count'];
                        // $classEvaluationitem[$course['name']] = $item['score'];
                        
                    } else {
                        $classEvaluationitem[$course['name']] = 0;
                    }
                }
                $classEvaluationitem['合计'] = $studentCount;
            } else {
                foreach ($selectCourses as $key => $course) {
                    $classEvaluationitem[$course['name']] = 0;
                }
                $classEvaluationitem["合计"] = 0;
            }
            $classEvaluationData[] = $classEvaluationitem;
        }
        // var_dump($classEvaluationData);die();
        echo $this->load->view('school/partial/class_evaluation_list', [
            'className' => $class['name'],
            'classEvaluationData' => $classEvaluationData,
            'selectCourses' => $selectCourses,
            'totalCount' => $totalCount,
            'totalScore' => $totalScore], true);
    }

    public function exportTeacherEvaluationData($stories)
    {
        // var_dump($stories);die();
        $list = $stories;
        $fp = fopen('php://output', 'w');
        // fputcsv($fp, "姓名,次数\n");
        foreach ($list as $fields) {
            fputcsv($fp, $fields);
            }

        $data = file_get_contents('php://output'); 
        $name = 'data.csv';

        // Build the headers to push out the file properly.
        header('Pragma: public');     // required
        header('Expires: 0');         // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private',false);
        header('Content-Disposition: attachment; filename="'.basename($name).'"');  // Add the file name
        header('Content-Transfer-Encoding: binary');
        header('Connection: close');
        exit();

        $this->_push_file($name, $data);
        fclose($fp);
    }

    public function _push_file($path, $name)
    {
          // make sure it's a file before doing anything!
          if(is_file($path))
          {
            // required for IE
            if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off'); }

            // get the file mime type using the file extension
            $this->load->helper('file');

            $mime = get_mime_by_extension($path);

            // Build the headers to push out the file properly.
            header('Pragma: public');     // required
            header('Expires: 0');         // no cache
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
            header('Cache-Control: private',false);
            header('Content-Type: '.$mime);  // Add the mime type from Code igniter.
            header('Content-Disposition: attachment; filename="'.basename($name).'"');  // Add the file name
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: '.filesize($path)); // provide file size
            header('Connection: close');
            readfile($path); // push it out
            exit();
        }
    }
}
