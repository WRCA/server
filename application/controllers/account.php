<?php
class Account extends CI_Controller{

    public function verificationCode() {

        // check parameters
        if (!isset($_GET['email'])) {
            $response = array('status' => 400, 'message' => 'parameters missing'); 
            echo json_encode($response);
            return;
        }

        $email = $_GET['email'];
        // find this email exist?
        $this->load->model('Resident_model', '', TRUE);
        $result = $this->Resident_model->contains_email($_GET['email']);
        if (!$result) {
            $response = array('status' => 400, 'message' => 'cannot find this email');
            echo json_encode($response);
            return;
        }

         // get its verification code
        $row = $this->Resident_model->get_row_by_email($email);

        // send email
        $message = "Hi Dear WRCA member,<br /><br /> This is your WRCA verification code#". $row->verification_code . "<br /><br /> WRCA App development group";
        $this->send_email($email, $message);
        $response = array('status' => 200, 'message' => 'please check your email box');
        echo json_encode($response);
    }

    // post request
    public function register() {

        // check parameters
        if (!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['verificationCode'])) {
            $response = array('status' => 400, 'message' => 'parameters missing'); 
            echo json_encode($response);
            return;
        }

        $email = $_POST['email'];
        $verificationCode = $_POST['verificationCode'];
        $password = $_POST['password'];

        if (empty($email) || empty($verificationCode) || empty($password)) {
            $response = array('status' => 400, 'message' => 'parameters value cannot be empty'); 
            echo json_encode($response);
            return;
        }

        // find this email exist?
        $this->load->model('Resident_model', '', TRUE);
        $result = $this->Resident_model->contains_email($email);
        if (!$result) {
            $response = array('status' => 400, 'message' => 'cannot find this email');
            echo json_encode($response);
            return;
        }

        // check verification match
        $row = $this->Resident_model->get_row_by_email($email);
        if ($row->verification_code != $verificationCode) {
            $response = array('status' => 400, 'message' => 'verification code not match');
            echo json_encode($response);
            return;
        }

        // insert into user table
        $this->load->model('User_model', '', TRUE);
        $result = $this->User_model->contains_email($email);
        if ($result) {
            $response = array('status' => 400, 'message' => 'account already registered');
            echo json_encode($response);
           return;
        }
        
        $authToken =  bin2hex(openssl_random_pseudo_bytes(16));
        $result = $this->User_model->insert_row($email, $password, $authToken);
        if (!$result) {
            $response = array('status' => 400, 'message' => 'verification code not match');
            echo json_encode($response);
            return;
        }

        $response = array('status' => 200, 'message' => 'register ok.');
        echo json_encode($response);
    } 
    public function login() {
        // check parameters
        if (!isset($_POST['email']) || !isset($_POST['password']) ) {
            $response = array('status' => 400, 'message' => 'parameters missing'); 
            echo json_encode($response);
            return;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        // user exist?
        $this->load->model('User_model', '', TRUE);
        $result = $this->User_model->contains_email($email);
        if (!$result) {
            $response = array('status' => 400, 'message' => 'user not exist');
            echo json_encode($response);
            return;
        }
        
        // match password?
        $row = $this->User_model->get_row_by_email($email);
        if ($row->password != $password) {
            $response = array('status' => 400, 'message' => 'password not match');
            echo json_encode($response);
            return;
        }

        // update authToken
        $authToken = bin2hex(openssl_random_pseudo_bytes(16));
        $result = $this->User_model->update_row($email, $password, $authToken);
        if (!$result) {
            $response = array('status' => 400, 'message' => 'update database error');
            echo json_encode($response);
            return;
        }

        $response = array('status' => 200, 'message' => 'login ok', 'authToken' => "$authToken");
        echo json_encode($response);
    }

    public function password() {
        // check parameters
        if (!isset($_GET['email']) ) {
            $response = array('status' => 400, 'message' => 'parameters missing'); 
            echo json_encode($response);
            return;
        }

        $email = $_GET['email'];
        // check email exist
        $this->load->model('User_model', '', TRUE);
        $result = $this->User_model->contains_email($email);
        if (!$result) {
            $response = array('status' => 400, 'message' => 'user not exist');
            echo json_encode($response);
            return;
        }

        // send email to user mail box
        $row = $this->User_model->get_row_by_email($email);
        $message = "Hi Dear WRCA member,<br /><br /> This is your WRCA app password#". $row->password . "<br /><br /> WRCA App development group";
        $this->send_email($email, $message);
        $response = array('status' => 200, 'message' => 'please check your email box');
        echo json_encode($response);
    }

    private function send_email($email, $message) {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'WRCADevelopmentGroup@gmail.com', // change it to yours
            'smtp_pass' => 'WRCADevelopmentGroup123', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('WRCADevelopmentGroup@domain.com'); // change it to yours
        $this->email->to($email); // change it to yours
        $this->email->subject('WRCA APP verification code');
        $this->email->message($message);

        $this->email->send();
    }

}
?>
