<?php
class Resident_model extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function contains_email($email) {
        $query = $this->db->query("SELECT * FROM resident WHERE email='$email'");
        $num = $query->num_rows();
        if ($num == 0) {
            return false;
        }
        return true;
    }

    public function get_row_by_email($email) {
        $query = $this->db->query("SELECT * FROM resident WHERE email = '$email'");
        return $query->row();
    }
}
?>
