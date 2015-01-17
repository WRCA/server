<?php
class Events extends CI_Controller {

    // define offset: 1 2 3 ...
    // define limit: number of items
    // example: offset = 3, limit = 5
    // start from id = 3, take 5 items from table
    // that's id in range [3, 7]
    public function index() {
        // check parameters

        if (!isset($_GET['authToken']) || !isset($_GET['range']) || !isset($_GET['offset'])
        || !isset($_GET['limit'])) {
            $response = array('status' => 400, 'message' => 'parameters missing'); 
            echo json_encode($response);
            return;
        }

        $authToken = $_GET['authToken'];
        $range = $_GET['range'];
        $offset = $_GET['offset'];
        $limit = $_GET['limit'];

        $start = $offset;
        $end = $offset + $limit - 1;

        // verify authToken
        $this->load->model('User_model', '', TRUE);
        $result = $this->User_model->contains_authorization_token($authToken);
        if (!$result) {
            $response = array('status' => 400, 'message' => 'token invalid'); 
            echo json_encode($response);
            return;
        }

        // fetch events and response
        switch ($range) {
            case 'all':
                $this->load->model('Event_model', '', TRUE);
                $rows = $this->Event_model->get_rows_by_id_range($start, $end);

                // total number
                $num = $this->Event_model->size();
                $nextOffset = $num > $end ? $end+1 : -1;
                
                if ($rows) {
                    $response = array('status' => 200, 'message' => 'ok', 'events' => $rows, 'nextOffset' => $nextOffset);
                } else {
                    $response = array('status' => 400, 'message' => 'server has no more data');
                }
                break;
                        
            case 'week':
                $this->load->model('Event_model', '', TRUE);
                $date = $this->get_date_range_of_this_week(); 
                $rows = $this->Event_model->get_rows_by_date_range($date['start'], $date['end'], $start, $end);
                $num = $this->Event_model->size_by_date_range($date['start'], $date['end']);
                $nextOffset = $num > $end ? $end+1 : -1;
                if ($rows) {
                    $response = array('status' => 200, 'message' => 'ok', 'events' => $rows, 'nextOffset' => $nextOffset);
                } else {
                    $response = array('status' => 400, 'message' => 'server has no more data');
                }
                break;

            case 'month':
                $this->load->model('Event_model', '', TRUE);
                $date = $this->get_date_range_of_this_month(); 
                $rows = $this->Event_model->get_rows_by_date_range($date['start'], $date['end'], $start, $end);
                $num = $this->Event_model->size_by_date_range($date['start'], $date['end']);
                $nextOffset = $num > $end ? $end+1 : -1;
                if ($rows) {
                    $response = array('status' => 200, 'message' => 'ok', 'events' => $rows, 'nextOffset' => $nextOffset);
                } else {
                    $response = array('status' => 400, 'message' => 'server has no more data');
                }

                break;
            default:
                $response = array('status' => 400, 'message' => 'range value not support'); 
        }

        echo json_encode($response);
        return;
    }

    public static function get_date_range_of_this_week() {
        $range['start'] = date("Y-m-d", time());
        $range['end'] = date("Y-m-d", strtotime('Sunday'));
        return $range;
    }
    public static function get_date_range_of_this_month() {
        date_default_timezone_set('America/New_York');
        $range['start'] = date("Y-m-d", time());
        $today =  date("Y-m-d H:i:s", time());
        $range['end'] = date("Y-m-t", strtotime($today));
        return $range;
    }


}

?>
