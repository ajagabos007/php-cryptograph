<?php
    ini_set('display_errors', true);
    require __DIR__.'/vendor/autoload.php';
    require __DIR__.'/connections/databases/MysqlConnection.php';
    require __DIR__.'/config/EmailConfig.php';


    use  \phpseclib3\Crypt\DES;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    use connections\database\MysqlConnection;
    use \config\MailConfig;


    class DesFactory extends Des {
        public $cipher_text;
        public $plain_text;
        public function getKey(){
            return $this->key;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            
        try {

            $sender_name = $_POST['sender_email']?? null;
            $sender_email = $_POST['sender_email']?? null;

            $receiver_name = $_POST['receiver_email']?? null;
            $receiver_email = $_POST['sender_email']?? null;

            $key = $_POST["key"] ?? '12345678';
            $subject = $_POST["subject"].' | '.$_SERVER['SERVER_NAME'] ?? 'Encrypted Message | '.$_SERVER['SERVER_NAME'];
            $message = $_POST["message"] ?? null;
            $send_me_a_copy = $_POST["send_me_a_copy"] ?? false;
            

            $form_data = [
                'sender name' => $sender_name,
                'sender email' => $sender_email,
                'receiver_email' => $receiver_email,
                'key' => $key,
                'message' => $message,
                'send me a copy' => $send_me_a_copy,
            ];

            // PERFORM ENCRYPTION 
            $des = new DesFactory('ctr');
            $des->setIV($key);
            $des->setKey($key);
            $des->cipher_text =  $des->encrypt($message);
            $encrpted_message = $des->cipher_text;

            // Create Database Coonection
            $mysql_db = new MysqlConnection();
            $mysql_con = $mysql_db->connect();
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $uuid = uniqid($prefix = "", $more_entropy=true);

            $sql_query = "INSERT INTO `operational_logs` (`uuid`, `user_agent`, `des_operation`, `des_text`, `des_key`, `des_result` ) VALUES ( '$uuid','$user_agent', 'encryption', '$message', '$key','$encrpted_message');";
            $query_run = $mysql_con->query ($sql_query);
            echo $mysql_con->error;
            if(!$query_run)
                throw new Exception("Error Processing Request: ".$sql_query . "<br/>" . $mysql_con->error."<br/>", 1);
        
            // SEND ENCRYPTED MESSAGE TO EMAIL
            //Create an instance; passing `true` enables exceptions

            $mail = new PHPMailer(true);
            
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = MailConfig::$HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = MailConfig::$USERNAME;                    //SMTP username
            $mail->Password   =  MailConfig::$PASSWORD;                               //SMTP password
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       =  MailConfig::$PORT;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($sender_email, $sender_name);
            $mail->addAddress($receiver_email, $receiver_name);     //Add a recipient
            if($send_me_a_copy)
                $mail->addAddress($sender_email, $sender_name);     //Add a recipient
            if (isset($_SERVER['HTTPS']) &&
                ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
                isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
                $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
              $protocol = 'https://';
            }
            else {
              $protocol = 'http://';
            }
            $host = $_SERVER['HTTP_HOST'];
            $domain = "/". explode('/', $_SERVER["SCRIPT_NAME"])[1];

            $url = $protocol.$host.$domain."/decrypt-email.php?res=". uniqid("",true)."&des_operation=decryption&salt=". uniqid("",true)."&uuid=".$uuid."&hash=". uniqid("",true);
             //Content of email 
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $message = "<h4>Hello ".$sender_name." </h4>";
            $message .="<P>This is an encryted message for you.<p>";
            $message .="<p><center>".$encrpted_message."</center></p>";
            $message .="<hr/>";
            $message .="<p>Copy and paste the link below on your browser to decrypt the message</p>";
            $message .="<p><small> <a href='".$url."'target='_blank'>".$url."</a></small></p>";
            $message .="<p><small>Kindly ignore if this message is not intended for you.</small></p>";
            $mail->Body    = $message;
            $mail->AltBody = strip_tags($message);

            // send email
            $mail->send();

            // get the operation log to save the mailable 
            $sql_query = "SELECT * FROM `operational_logs` WHERE `uuid` = '$uuid'  LIMIT 1 ";
            $result = $mysql_con->query($sql_query);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                $operational_log_id =  $row["id"];
                }
            } else {
                throw new Exception("Error Processing Request: ".$sql_query . "<br/>" . $mysql_con->error."<br/>", 1);
            }

            // save the mailable 
            $sql_query = "INSERT INTO `mailables` (`sender_name`, `sender_email`, `receiver_email`, `reciever_email`, `operational_log_id`) VALUES ('$sender_name', '$sender_email', '$receiver_name', '$receiver_email', '$operational_log_id');";
            $result = $mysql_con->query($sql_query);

            if(!$result)
                throw new Exception("Error Processing Request: ".$sql_query . "<br/>" . $mysql_con->error."<br/>", 1);
            
            $response = array(
                "status" => 200,
                "message" => "Message sent successfully",
            );
            echo json_encode($response);
            exit();

        }  catch (\Throwable $th) {
            $response = array(
                "status" => 422,
                "message" => "Mailing operation failed <br/>".$th,
            );
            echo json_encode($response);
            exit();
        }
       
    }

?>



