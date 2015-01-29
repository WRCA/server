<?php
class Gcm_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function get_rows_all() {
        $query = $this->db->query("SELECT * FROM gcm");
        $rows = array();
        foreach ($query->result_array() as $row) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function size() {
        $query = $this->db->query("SELECT * FROM gcm");
        return $query->num_rows();
    }

    public function insert_row($name, $email, $gcm_regid) {
        $query = $this->db->query( "INSERT INTO gcm (id, gcm_regid, name, email) VALUES (default, '$gcm_regid', '$name',  '$email')" );
        if (!$query) {
            return false;
        }
        return true;
    } 
}
?>
