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
        $sql = "UPDATE evaluation_details SET description = ?, last_updated_by = ?, last_update_date = ?, evaluation_indexs_id = ?, order_number = ? WHERE id = ?";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(2, $data['lastUpdatedBy'], PDO::PARAM_INT);
        $stmt->bindParam(3, $data['lastUpdatedDate'], PDO::PARAM_INT);
        $stmt->bindParam(4, $data['evaluation_indexs_id'], PDO::PARAM_INT);
        $stmt->bindParam(5, $data['orderNumber'], PDO::PARAM_INT);
        $stmt->bindParam(6, $data['id'], PDO::PARAM_INT);
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
/*
    public function getGroups()
    {
        $sql = "SELECT * FROM customer_types";
        $stmt = $this->getStatement($sql);
        // $stmt = $this->db->conn_id->prepare($sql);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        }
        
        return false;
    }

    public function getOneGroup($customerTypesId)
    {
        $sql = "SELECT * FROM customer_types where id = ?";
        $stmt = $this->getStatement($sql);
        // $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $customerTypesId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetch();
        }
        
        return false;
    }

    public function addGroup()
    {
        $sql = "SELECT * FROM customer_types";
        $stmt = $this->getStatement($sql);
        // $stmt = $this->db->conn_id->prepare($sql);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        }
        
        return false;
    }

    public function updateGroup()
    {
        $sql = "SELECT * FROM customer_types";
        $stmt = $this->getStatement($sql);
        // $stmt = $this->db->conn_id->prepare($sql);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        }
        
        return false;
    }

    public function getOneGroup($customerTypesId)
    {
        $sql = "SELECT * FROM customer_types where id = ?";
        $stmt = $this->getStatement($sql);
        // $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $customerTypesId, PDO::PARAM_INT);
        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetch();
        }
        
        return false;
    }
*/


}