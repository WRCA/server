<?php
class User_model extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function insert_row($email, $password, $token) {
        $query = $this->db->query( "INSERT INTO user (id, email, password, token) VALUES (default, '$email', '$password',  '$token')" );
        if (!$query) {
            return false;
        }
        return true;

    } 
    public function update_row($email, $password, $token) {
        $query = $this->db->query("UPDATE user set password='$password', token='$token' WHERE email='$email'");

        if (!$query) {
            return false;
        }
        return true;
    }
    public function get_row_by_email($email) {
        $query = $this->db->query( "SELECT * FROM user WHERE email = '$email'");
        return $query->row();
    }

    public function contains_email($email) {

        $query = $this->db->query("SELECT * FROM user WHERE email='$email'");
        $num = $query->num_rows();
        if ($num == 0) {
            return false;
        }
        return true;
    }

    public function contains_authorization_token($authToken) {
        $query = $this->db->query("SELECT * FROM user WHERE token='$authToken'");
        $num = $query->num_rows();
        if ($num == 0) {
            return false;
        }
        return true;
    }
}
?>
