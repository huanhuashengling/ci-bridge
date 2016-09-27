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
        $sql = "SELECT * FROM teachers WHERE users_id = ?";
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
    
    public function getClassStudentsByClassesId($classesId)
    {
        $sql = "SELECT u.*, s.* FROM users as u 
                LEFT JOIN students as s ON u.id = s.users_id
                WHERE 1
                AND s.classes_id = ?";
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

    public function getEvaluateCountByStudentsId($studentsId)
    {
        $sql = "SELECT e.* FROM evaluation as e 
                LEFT JOIN courses as c ON c.id = e.courses_id
                WHERE students_users_id = ?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $studentsId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        }
        
        return false;
    }

}