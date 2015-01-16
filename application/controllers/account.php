<?php
class Account extends CI_Controller{
    public function index() {
        echo "hello world!";
    }

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

    public function register() {
    } 
    public function login() {
    }

    public function password() {
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
