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
        $this->load->library('pinyinfirstchar');
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

            $courses = $this->UsersModel->getCoursesByTeachersId($usersId);
            if (0 == count($courses)) {
                $courses = $this->UsersModel->getCourses();
            }
            $courseHtml = $this->getCourseHtml($courses);

            $evaluationIndexHtml = $this->getEvaluationIndexHtml($courses[0]['id']);
            
            $evaluationIndexInfo = $this->UsersModel->getCourseEvaluationIndexs($courses[0]['id']);

            $evaluationDetailHtml = $this->getEvaluationDetailHtml($evaluationIndexInfo[0]['id']);

            $response = ['courseHtml' => $courseHtml, 'studentsHtml' => $studentsHtml, 'evaluationIndexHtmlContent' => $evaluationIndexHtml, 'evaluationDetailHtmlContent' => $evaluationDetailHtml];

            echo json_encode($response);
        }
    }

    public function ajaxReloadStudentsList()
    {
        $post = $this->input->post();
        $classesId = $this->session->userdata("classesId");

        echo $this->getStudentsHtml($classesId, $post['orderBy']);

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
        // $params['manager'] = $user['manager'];
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
             if ($studentsId) {
                $evaluationData['studentsUsersId'] = $studentsId;
                $newEvaluationId = $this->UsersModel->submitEvaluation($evaluationData);
                if (!$newEvaluationId) {
                    echo "false";
                    return;
                }
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
        // $params['manager'] = $user['manager'];
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
        // $params['manager'] = $user['manager'];
        $obj = [
            'body' => $this->load->view('teacher/class_student_info', ['studentsData' => $studentsData, 'classesId'=>$user['class_teacher'], 'enableDelete' => 'disabled'], true),
            'csses' => [],
            'jses' => ['/js/pages/class-student-info.js'],
            'header' => $this->load->view('teacher/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function classDailyEvaluate()
    {
        $usersId = $this->session->userdata("user_id");
        $user = $this->UsersModel->getTeachersInfoByUsersId($usersId);

        $classes = $this->UsersModel->getClasses();
        $classesData = [];
        foreach ($classes as $key => $class) {
            $classesData[$class['grade_number']][] = $class;
        }

        $params = $this->_getParams();
        $params['courseLeader'] = $user['course_leader'];
        $params['classTeacher'] = $user['class_teacher'];
        // $params['manager'] = $user['manager'];
        $obj = [
            'body' => $this->load->view('teacher/class_daily_evaluate', ['classesData' => $classesData], true),
            'csses' => [],
            'jses' => [],
            'header' => $this->load->view('teacher/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function evaluationHistory()
    {
        // $schoolTermData = ['20162' => ['schoolTermName' => '2016年下学期', 'startWeeNum' => 34], '20171' => ['schoolTermName' => '2017年上学期', 'startWeeNum' => 6]];
        $weekData = ["所有周次", "第一周", "第二周", "第三周", "第四周", "第五周", "第六周", "第七周", "第八周", "第九周", "第十周", "第十一周", "第十二周", "第十三周", "第十四周", "第十五周", "第十六周", "第十七周", "第十八周", "第十九周", "第二十周"];
        // $schoolTermSelect = $this->session->userdata("evaluationHistorySchoolTermSelect");
        $weekSelect = $this->session->userdata("evaluationHistoryWeekSelect");
        $classSelect = $this->session->userdata("evaluationHistoryClassSelect");
        $courseSelect = $this->session->userdata("evaluationHistoryCourseSelect");
        $studentNameSelect = $this->session->userdata("evaluationHistoryStudentNameSelect");
        
        // if (!isset($schoolTermSelect)) {
        //     $schoolTermSelect = "20171";
        // }


        $startWeeNum = 0;//$schoolTermData[$schoolTermSelect]['startWeeNum'];

        if (!isset($weekSelect)) {
            $weekNum = date('W', time());
            $weekSelect = $weekNum - $startWeeNum;
        } else {
            $weekNum = (0 == $weekSelect)?null:($weekSelect + $startWeeNum);
        }

        $usersId = $this->session->userdata("user_id");
        $user = $this->UsersModel->getTeachersInfoByUsersId($usersId);

        $evaluationData = $this->UsersModel->getTeacherEvaluationData($usersId, $weekNum, null, null, $classSelect, $courseSelect, $studentNameSelect);
        $courses = $this->UsersModel->getCoursesByTeachersId($usersId);
        if (0 == count($courses)) {
            $courses = $this->UsersModel->getCourses();
        }
        $classes = $this->UsersModel->getClasses();

        $config = array();
        $config["base_url"] = base_url() . "teacher/evaluation-history";
        $total_row = count($evaluationData);
        $config["total_rows"] = $total_row;
        $config["per_page"] = 20;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 2;
        // $config['cur_page'] = $recno;
        // $config['cur_tag_open'] = '&nbsp;<a class="current">';
        // $config['cur_tag_close'] = '</a>';
        // $config['next_link'] = '&gt;';
        // $config['prev_link'] = '&lt;';
        // $config['first_link'] = '&lt;&lt;';
        // $config['last_link'] = '&gt;&gt;';
        // $config['num_tag_open'] = '<li>';
        // $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        if ($this->uri->segment(3)) {
            $page = ($this->uri->segment(3)) ;
        } else {
            $page = 1;
        }
        // if (isset($studentNameSelect)) {
        //     $page = 1;
        // }
        // echo "<br>segment  " . $this->uri->segment(4);
        // echo "<br>per_page  " . $config["per_page"];
        // echo "<br>page  " . $page;
        $evaluationData = $this->UsersModel->getTeacherEvaluationData($usersId, $weekNum, $config["per_page"], $page, $classSelect, $courseSelect, $studentNameSelect);
        $startOrder = $config["per_page"] * ($page - 1);
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );

        $params = $this->_getParams();
        $params['courseLeader'] = $user['course_leader'];
        $params['classTeacher'] = $user['class_teacher'];
        // $params['manager'] = $user['manager'];
        $obj = [
            'body' => $this->load->view('teacher/evaluation_history', 
                                    ['evaluationData' => $evaluationData, 
                                    // 'schoolTermData' => $schoolTermData, 
                                    // 'schoolTermSelect' => $schoolTermSelect,
                                    "data" => $data, 
                                    'startOrder' => $startOrder,
                                    "courses" => $courses, 
                                    'classes' => $classes,
                                    'weekSelect' => $weekSelect,
                                    'courseSelect' => $courseSelect,
                                    'classSelect' => $classSelect,
                                    'studentNameSelect' => $studentNameSelect,
                                    'weekData' => $weekData,
                                    'total_row' => $total_row], true),
            'csses' => [],
            'jses' => ['/js/pages/evaluation-history.js'],
            'header' => $this->load->view('teacher/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function evaluationReport()
    {
        $weekData = ["所有周次", "第一周", "第二周", "第三周", "第四周", "第五周", "第六周", "第七周", "第八周", "第九周", "第十周", "第十一周", "第十二周", "第十三周", "第十四周", "第十五周", "第十六周", "第十七周", "第十八周", "第十九周", "第二十周"];
        $todaySelect = $this->session->userdata("evaluationReportTodaySelect");
        $weekSelect = $this->session->userdata("evaluationReportWeekSelect");
        $classSelect = $this->session->userdata("evaluationReportClassSelect");
        $courseSelect = $this->session->userdata("evaluationReportCourseSelect");
        $startWeeNum = 0;

        if (!isset($weekSelect)) {
            $weekNum = date('W', time());
            $weekSelect = $weekNum - $startWeeNum;
        } else {
            $weekNum = (0 == $weekSelect)?null:($weekSelect + $startWeeNum);
        }

        $usersId = $this->session->userdata("user_id");
        $user = $this->UsersModel->getTeachersInfoByUsersId($usersId);

        $evaluationData = $this->UsersModel->getEvaluationCount($usersId, $weekNum, $classSelect, $courseSelect, $todaySelect);
// var_dump($evaluationData);die();
        // count for report info
        $evaluateCount = 0;
        foreach ($evaluationData as $key => $item) {
            $evaluateCount += $item['count'];
        }
        $courses = $this->UsersModel->getCoursesByTeachersId($usersId);
        if (0 == count($courses)) {
            $courses = $this->UsersModel->getCourses();
        }
        $classes = $this->UsersModel->getClasses();

        $params = $this->_getParams();
        $params['courseLeader'] = $user['course_leader'];
        $params['classTeacher'] = $user['class_teacher'];
        // $params['manager'] = $user['manager'];
        $obj = [
            'body' => $this->load->view('teacher/evaluation_report', 
                                    ['evaluationData' => $evaluationData, 
                                    "courses" => $courses, 
                                    'classes' => $classes,
                                    'todaySelect' => $todaySelect,
                                    'weekSelect' => $weekSelect,
                                    'courseSelect' => $courseSelect,
                                    'classSelect' => $classSelect,
                                    'evaluateCount' => $evaluateCount,
                                    'weekData' => $weekData], true),
            'csses' => [],
            'jses' => ['/js/pages/evaluation-report.js'],
            'header' => $this->load->view('teacher/header', $params, true),
        ];
        $this->_render($obj);
    }

    public function ajaxFilterEvaluationReport()
    {
        $post = $this->input->post();
        $this->session->set_userdata("evaluationReportTodaySelect", $post['todaySelect']);
        $this->session->set_userdata("evaluationReportWeekSelect", $post['weekSelect']);
        $this->session->set_userdata("evaluationReportClassSelect", $post['classSelect']);
        $this->session->set_userdata("evaluationReportCourseSelect", $post['courseSelect']);
    }

    public function ajaxFilterEvaluationHistory()
    {
        $post = $this->input->post();
        // $this->session->set_userdata("evaluationHistorySchoolTermSelect", $post['schoolTermSelect']);
        $this->session->set_userdata("evaluationHistoryWeekSelect", $post['weekSelect']);
        $this->session->set_userdata("evaluationHistoryClassSelect", $post['classSelect']);
        $this->session->set_userdata("evaluationHistoryCourseSelect", $post['courseSelect']);
        $this->session->set_userdata("evaluationHistoryStudentNameSelect", $post['studentNameSelect']);
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

    public function ajaxDeleteStudent()
    {
        $post = $this->input->post();
        // $studentsId = $post['studentsId'];


        echo $this->ion_auth->deactivate($post['studentsId']);
    }

    public function ajaxActiveStudent()
    {
        $post = $this->input->post();
        if ("activate" == $post['action']) {
            echo $this->ion_auth->activate($post['studentsId']);
        } else {
            echo $this->ion_auth->deactivate($post['studentsId']);
        }
    }

    public function getIndexEvaluateContent()
    {
        $post = $this->input->post();
        $evaluationIndexsId = $post['evaluationIndexsId'];

        $evaluationDetailHtml = $this->getEvaluationDetailHtml($evaluationIndexsId);
        echo $evaluationDetailHtml;
    }

    public function getStudentsHtml($classesId, $orderBy = "name")
    {
        $class = $this->UsersModel->getOneClasses($classesId);
        $selectedStudentsData = $this->UsersModel->getClassStudentsByClassesId($classesId, false, $orderBy);
        $studentCount = count($selectedStudentsData);
        $maxNumPerLine = 6;
        if ("name" == $orderBy) {
            $selectedStudentsData = $this->changeStudentDateToVerticalOrder($selectedStudentsData, $maxNumPerLine);
        }
        $num = 1;

        $studentsHtml = "<div class='row'><div class='col-md-2 col-xs-2'><a class='btn btn-default' href='/teacher/classroom-evaluation'><<返回班级选择</a></div><div class='col-md-2 col-xs-2'><h4>".$class['name']."班 (".$studentCount."<span id='selectedCount'>/0</span>)</h4></div>" . 
            "<div class='col-md-2 col-xs-2'><a class='btn btn-default' id='order-by-name'>按姓名排序</a></div>" . 
            "<div class='col-md-2 col-xs-2'><a class='btn btn-default' id='order-by-number'>按学号排序</a></div>" . 
            "<div class='col-md-2 col-xs-2'><a class='btn btn-default' id='select-all'>全选名单</a></div>" . 
            "<div class='col-md-2 col-xs-2'><a class='btn btn-default' id='un-select-all'>取消全选</a></div></div>";
        $studentsHtml =  $studentsHtml . "<table class='table table-striped table-hover table-condensed'><tr>";
            
        foreach ($selectedStudentsData as $key => $student) {
          $btnClass = (0 == $student['gender'])?"btn-danger":"btn-primary";
          $gender = (0 == $student['gender'])?"gender='girl'":"gender='boy'";
          // $firstChar = $this->pinyinfirstchar->getFirstchar(substr($student['username'], 0, 1));
          $firstChar = $this->pinyinfirstchar->getFirstchar($student['username']);
          if ($num < $maxNumPerLine) {
            $num++;
            $studentsHtml =  $studentsHtml . "<td>".$firstChar."&nbsp;&nbsp<button class='btn " . $btnClass . " student-btn' " . $gender . " value='" . $student['id'] . "'>" . $student['username'] . "</button></td>";
          } else {
            $num = 1;
            $hidden = ("" == $student['username'])?"hidden":"";
            $studentsHtml =  $studentsHtml . "<td>".$firstChar."&nbsp;&nbsp<button class='btn " . $btnClass . " ".$hidden." student-btn' " . $gender . " value='" . $student['id'] . "'>" . $student['username'] . "</button></td></tr><tr>";
          }
                
        }
        $studentsHtml =  $studentsHtml . "</tr></table>";

        return $studentsHtml;
    }

    public function getCourseHtml($courses)
    {
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

    public function changeStudentDateToVerticalOrder($selectedStudentsData, $maxNumPerLine)
    {

        $newSelectedStudentsData = [];
        $verticalNum = ceil(count($selectedStudentsData)/$maxNumPerLine);
        // echo "verticalNum  " . $verticalNum . " maxNumPerLine " . $maxNumPerLine . " count " . count($selectedStudentsData);
        for ($i=0; $i < $verticalNum; $i++) { 
            for ($j=0; $j < $maxNumPerLine; $j++) { 
                if (isset($selectedStudentsData[$j * $verticalNum + $i])) {
                    $newSelectedStudentsData[] = $selectedStudentsData[$j * $verticalNum + $i];
                } else {
                    $newSelectedStudentsData[] = ["gender" => 0, 'username'=>"", 'id' => 0];
                }
            }
        }
        return $newSelectedStudentsData;

    }
}
