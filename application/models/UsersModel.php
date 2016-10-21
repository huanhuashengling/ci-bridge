<?php
Class UsersModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function getOneUser($usersId)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $usersId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetch();
        }
        
        return false;
    }

    public function getTeachersInfoByUsersId($usersId)
    {
        $sql = "SELECT t.*, u.* FROM teachers as t LEFT JOIN users as u ON u.id = t.users_id WHERE t.users_id = ?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $usersId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetch();
        }
        
        return false;
    }
    
    public function getOneCourse($coursesId)
    {
        $sql = "SELECT * FROM courses WHERE id = ?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $coursesId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetch();
        }
        
        return false;
    }

    public function getCourses()
    {
        $sql = "SELECT * FROM courses";
        $stmt = $this->db->conn_id->prepare($sql);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        }
        
        return false;
    }

    public function getCourseEvaluationIndexs($coursesId)
    {
        $sql = "SELECT * FROM evaluation_indexs WHERE courses_id = ? ORDER BY order_number ASC";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $coursesId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        }
        
        return false;
    }

    public function getCourseEvaluationDetails($indexsId)
    {
        $sql = "SELECT * FROM evaluation_details WHERE evaluation_indexs_id = ? ORDER BY order_number ASC";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $indexsId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        }
        
        return false;
    }

    public function addEvaluationIndex($data)
    {
        $sql = "INSERT INTO evaluation_indexs (description, last_updated_by, last_update_date, courses_id, order_number) values (?,?,?,?,?)";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(2, $data['lastUpdatedBy'], PDO::PARAM_STR);
        $stmt->bindParam(3, $data['lastUpdateDate'], PDO::PARAM_STR);
        $stmt->bindParam(4, $data['coursesId'], PDO::PARAM_INT);
        $stmt->bindParam(5, $data['orderNumber'], PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            $itemId = $this->db->insert_id();
            return $itemId;
        }
        
        return false;
    }

    public function editEvaluationIndex($data)
    {
        $sql = "UPDATE evaluation_indexs SET description = ?, last_updated_by = ?, last_update_date = ?, courses_id = ?, order_number = ? WHERE id = ?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(2, $data['lastUpdatedBy'], PDO::PARAM_INT);
        $stmt->bindParam(3, $data['lastUpdatedDate'], PDO::PARAM_INT);
        $stmt->bindParam(4, $data['coursesId'], PDO::PARAM_INT);
        $stmt->bindParam(5, $data['orderNumber'], PDO::PARAM_INT);
        $stmt->bindParam(6, $data['id'], PDO::PARAM_INT);
        $success = $stmt->execute();
        
        return $success;
    }

    public function delEvaluationIndex($data)
    {
        $sql = "DELETE FROM evaluation_indexs WHERE id = ?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $data['id'], PDO::PARAM_INT);
        $success = $stmt->execute();
        
        return $success;
    }

    public function addEvaluationDetail($data)
    {
        $sql = "INSERT INTO evaluation_details (description, last_updated_by, last_update_date, evaluation_indexs_id, order_number) values (?,?,?,?,?)";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(2, $data['lastUpdatedBy'], PDO::PARAM_INT);
        $stmt->bindParam(3, $data['lastUpdatedDate'], PDO::PARAM_INT);
        $stmt->bindParam(4, $data['evaluationIndexsId'], PDO::PARAM_INT);
        $stmt->bindParam(5, $data['orderNumber'], PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            $itemId = $this->db->insert_id();
            return $itemId;
        }
        
        return false;
    }

    public function editEvaluationDetail($data)
    {
        $sql = "UPDATE evaluation_details SET description = ?, last_updated_by = ?, last_update_date = ?, order_number = ? WHERE id = ?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(2, $data['lastUpdatedBy'], PDO::PARAM_INT);
        $stmt->bindParam(3, $data['lastUpdatedDate'], PDO::PARAM_INT);
        $stmt->bindParam(4, $data['orderNumber'], PDO::PARAM_INT);
        $stmt->bindParam(5, $data['id'], PDO::PARAM_INT);
        $success = $stmt->execute();
        
        return $success;
    }

    public function delEvaluationDetail($data)
    {
        $sql = "DELETE FROM evaluation_details WHERE id = ?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $data['id'], PDO::PARAM_INT);
        $success = $stmt->execute();
        
        return $success;
    }

    public function delEvaluationDetailByIndexId($indexId)
    {
        $sql = "DELETE FROM evaluation_details WHERE evaluation_indexs_id = ?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $indexId, PDO::PARAM_INT);
        $success = $stmt->execute();
        
        return $success;
    }

    public function getClasses()
    {
        $sql = "SELECT * FROM classes";
        $stmt = $this->db->conn_id->prepare($sql);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        }
        
        return false;
    }

    public function getOneClasses($classesId)
    {
        $sql = "SELECT * FROM classes WHERE id=?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $classesId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetch();
        }
        
        return false;
    }
    
    public function getClassStudentsByClassesId($classesId, $orderBy)
    {
        $order = "";
        if (isset($orderBy) && ("name" == $orderBy)) {
            $order = "ORDER BY CONVERT( username USING gbk )";
        }

        $sql = "SELECT u.*, s.* FROM users as u 
                LEFT JOIN students as s ON u.id = s.users_id
                WHERE 1
                AND s.classes_id = ?
                $order";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $classesId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        }
        
        return false;
    }

    public function getClassStudents($data)
    {
        $sql = "SELECT u.*, s.* FROM users as u 
                LEFT JOIN students as s ON u.id = s.users_id
                WHERE 1
                AND grade_number = ?
                AND class_number = ?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $data['grade_number'], PDO::PARAM_INT);
        $stmt->bindParam(2, $data['class_number'], PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        }
        
        return false;
    }

    public function addStudentAddtionalData($data)
    {
        $sql = "INSERT INTO students (users_id, edu_starting_year, city_student_number, national_student_number, gender, birth_date, classes_id) values (?,?,?,?,?,?,?)";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $data['usersId'], PDO::PARAM_INT);
        $stmt->bindParam(2, $data['eduStartingYear'], PDO::PARAM_STR);
        $stmt->bindParam(3, $data['cityStudentNumber'], PDO::PARAM_STR);
        $stmt->bindParam(4, $data['nationalStudentNumber'], PDO::PARAM_STR);
        $stmt->bindParam(5, $data['gender'], PDO::PARAM_INT);
        $stmt->bindParam(6, $data['birthDate'], PDO::PARAM_STR);
        $stmt->bindParam(7, $data['classesId'], PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            $itemId = $this->db->insert_id();
            return $itemId;
        }
        
        return false;
    }

    public function addTeacherAddtionalData($data)
    {
        $sql = "INSERT INTO teachers (users_id, course_leader, class_teacher) values (?,?,?)";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $data['usersId'], PDO::PARAM_INT);
        $stmt->bindParam(2, $data['courseLeader'], PDO::PARAM_STR);
        $stmt->bindParam(3, $data['classTeacher'], PDO::PARAM_STR);
        $success = $stmt->execute();

        if ($success) {
            $itemId = $this->db->insert_id();
            return $itemId;
        }
        
        return false;
    }

    public function getCoursesByTeachersId($teachersId)
    {
        $sql = "SELECT c.* FROM courses_teachers as ct 
                LEFT JOIN courses as c ON c.id = ct.courses_id
                WHERE teachers_users_id = ?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $teachersId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        }
        return false;
    }

    public function submitEvaluation($data)
    {
        $sql = "INSERT INTO evaluation (evaluate_date, courses_id, evaluation_indexs_id, evaluation_details_id, scores_id, teachers_users_id, students_users_id) values (?,?,?,?,?,?,?)";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $data['evaluateDate'], PDO::PARAM_STR);
        $stmt->bindParam(2, $data['coursesId'], PDO::PARAM_INT);
        $stmt->bindParam(3, $data['evaluationIndexsId'], PDO::PARAM_INT);
        $stmt->bindParam(4, $data['evaluationDetailsId'], PDO::PARAM_INT);
        $stmt->bindParam(5, $data['scoresId'], PDO::PARAM_INT);
        $stmt->bindParam(6, $data['teachersUsersId'], PDO::PARAM_INT);
        $stmt->bindParam(7, $data['studentsUsersId'], PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            $itemId = $this->db->insert_id();
            return $itemId;
        }
        
        return false;
    }

    public function getEvaluateCountByStudentsId($studentsId, $coursesId = NULL)
    {
        $courseMatch = "";
        if (isset($coursesId)) {
            $courseMatch = "AND c.id = " . $coursesId;
        }
        $sql = "SELECT c.name as course_name, c.id as courses_id, count(*) as evaluate_count, sum(s.score) as score 
                FROM evaluation as e 
                LEFT JOIN courses as c ON c.id = e.courses_id 
                LEFT JOIN scores as s ON s.id = e.scores_id 
                WHERE students_users_id = ? 
                $courseMatch 
                GROUP BY courses_id";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $studentsId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        }
        
        return false;
    }

    public function deleteAllStudentsData()
    {
        $sql = "DELETE FROM students WHERE";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $teachersId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        }
        
        return false;
    }
    
    public function getAllTeachers()
    {
        $sql = "SELECT u.*, t.*, cl.name as class_name, c.name as course_name FROM teachers as t 
                LEFT JOIN users as u ON u.id = t.users_id
                LEFT JOIN courses as c ON t.course_leader = c.id
                LEFT JOIN classes as cl ON cl.id = t.class_teacher
                WHERE 1";
        $stmt = $this->db->conn_id->prepare($sql);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        }
        
        return false;
    }
    
    public function updateTeachersInfo($teachersId, $courseLeader, $classTeacher)
    {
        $sql = "UPDATE teachers SET course_leader=?, class_teacher=?
                WHERE 1
                AND users_id=?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $courseLeader, PDO::PARAM_INT);
        $stmt->bindParam(2, $classTeacher, PDO::PARAM_INT);
        $stmt->bindParam(3, $teachersId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return true;
        }
        
        return false;
    }
    
    public function deleteCoursesTeachersByTeachersId($teachersId)
    {
        $sql = "DELETE FROM courses_teachers WHERE teachers_users_id=?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $teachersId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return true;
        }
        
        return false;
    }

    public function addCoursesTeachers($teachersId, $coursesId)
    {
        $sql = "INSERT courses_teachers (courses_id, teachers_users_id) VALUES(?,?)";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $coursesId, PDO::PARAM_INT);
        $stmt->bindParam(2, $teachersId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            $itemId = $this->db->insert_id();
            return $itemId;
        }
        
        return false;
    }

    public function getTeacherEvaluationData($usersId, $weekNum = null, $perPage = null, $pageNum = null)
    {
        $weekNumMatch = (!isset($weekNum) || (0 == $weekNum))?"":" AND weekofyear(e.evaluate_date) = ".$weekNum;
        $limitMatch = isset($perPage)?" LIMIT " . ($perPage * ($pageNum - 1)) . ", " . $perPage:"";
        $sql = "SELECT e.*, weekofyear(e.evaluate_date) as week_num, c.name as course_name, cl.name as class_name, s.name as score_name, u.username, ei.description as index_desc, ed.description as detail_desc
                FROM evaluation as e 
                LEFT JOIN users as u ON u.id = e.students_users_id 
                LEFT JOIN students as st ON st.users_id = e.students_users_id 
                LEFT JOIN classes as cl ON cl.id = st.classes_id 
                LEFT JOIN courses as c ON c.id = e.courses_id 
                LEFT JOIN scores as s ON s.id = e.scores_id 
                LEFT JOIN evaluation_indexs as ei ON ei.id = e.evaluation_indexs_id 
                LEFT JOIN evaluation_details as ed ON ed.id = e.evaluation_details_id 
                WHERE 1
                AND teachers_users_id = ?
                $weekNumMatch
                ORDER BY e.evaluate_date DESC
                $limitMatch";
            // echo $sql;die();
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $usersId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        }
        
        return false;
    }

    public function deleteEvaluateItem($evaluationId)
    {
        $sql = "DELETE FROM evaluation WHERE id=?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $evaluationId, PDO::PARAM_INT);
        $success = $stmt->execute();
        if ($success) {
            return true;
        }
        return false;
    }

    public function getCourseByName($courseLeader)
    {
        $sql = "SELECT * FROM courses WHERE name = ?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $courseLeader, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetch();
        }
        
        return false;
    }

    public function getClassByName($classTeacher)
    {
        $sql = "SELECT * FROM classes WHERE name = ?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $classTeacher, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetch();
        }
        
        return false;
    }

}