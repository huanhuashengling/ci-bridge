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