<?php 
class Gcm extends CI_Controller {

    private $API_KEY = "AIzaSyC_Xocwf_A8wqecaLI1z4nfnt2oT8QZhIw";

    public function register() {
        if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["regId"])) {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $gcm_regid = $_POST["regId"]; // GCM Registration ID


            $this->load->model('Gcm_model', '', TRUE);
            $result = $this->Gcm_model->insert_row($name, $email, $gcm_regid);

            $registatoin_ids = array($gcm_regid);
            $message = array("I" => "like it.");

            $result = $this->send_notification($registatoin_ids, $message);
        }
    }

    public function unregister() {
        // placeholder method
    }


    private function send_notification($registatoin_ids, $message) {

        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );

        $headers = array(
            'Authorization: key=' . $this->API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        echo $result;
    }
}
?>
