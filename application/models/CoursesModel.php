<?php
Class CoursesModel extends CI_Model
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

}