<?php

class Event_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function get_rows_by_date_range($date_start, $date_end, $begin, $end) {
        $query = $this->db->query("SELECT * FROM event WHERE time BETWEEN '$date_start' AND '$date_end'");

        $rows = array();
        for ($i = $begin; $i <= $end; $i++) {
            if ($i > $query->num_rows()) {
                break;
            }
            $rows[] = $query->row_array($i);
        }
        
        return $rows;
    }
    public function size_by_date_range($date_start, $date_end) {
        $query = $this->db->query("SELECT * FROM event WHERE time BETWEEN '$date_start' AND '$date_end'");
        return  $query->num_rows();
    }
    public function get_rows_by_id_range($begin, $end) {
        $query = $this->db->query("SELECT * FROM event WHERE id BETWEEN '$begin' AND '$end'");
        $rows = array();
        foreach ($query->result_array() as $row) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function size() {
        $query = $this->db->query("SELECT * FROM event" );
        return $query->num_rows();
    }
}
?>

