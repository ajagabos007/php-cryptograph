<?php
namespace connections;
require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../config/EmailConfig.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use config\MailConfig;
 
class EmailConnection {
    private $host;
    private $username;
    private $password;
    private $port;
    private $is_smtp = true;
    private $smtp_debug=false;
    private $smtp_auth=true; 
    private $smtp_secure=false;
    private $mailer = null;


    public function connect(
        $host=NULL, 
        $username=NULL, 
        $password=NULL, 
        $port=NULL, 
        $is_smtp=true,
        $smtp_debug=false, 
        $smtp_auth=true, 
        $smtp_secure=false
    )
    {

        if($host)
            $this->host = $mail_host ;
        else $this->host = MailConfig::$HOST;

        if($username)
            $this->username = $username ;
        else $this->username = MailConfig::$USERNAME;

        if($password)
            $this->password = $password ;
        else $this->password = MailConfig::$PASSWORD;

        if($port)
            $this->port = $port ;
        else $this->port = MailConfig::$PORT;

        if ($smtp_auth)
        $this->smtp_auth = $smtp_auth;
       else $this->smtp_auth = MailConfig::$SMTP_AUTH;

       $mailer = new PHPMailer(true);

       if($is_smtp){
            $this->is_smtp= $is_smtp;
            $mailer->isSMTP();  //Send using SMTP
       }
       if ($smtp_debug){
            $this->smtp_debug = $smtp_debug;
            $mailer->SMTPDebug = SMTP::DEBUG_SERVER;    //Enable verbose debug output  
       }  
       if ($smtp_secure){
            $this->smtp_secure = $smtp_secure;
            $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   //Enable implicit TLS encryption
        }
       
        $this->mailer = $mailer;
        return $mailer;
    }

    public function dumpSettings(){
        print_r(
            [
                "Host" => $this->host,
                "username" => $this->username,
                "password" => $this->password,
                "port" => $this->port,
                // "is_smtp" => $this->is_smtp,
                // "smtp_debug" => $this->smtp_debug,
                // "smtp_auth" => $this->smtp_auth, 
                "smtp_secure" => $this->smtp_secure,
                // "mailer" => $this->mailer,
            ]
        );

        echo"<br/></br>";
        die("");
    }
}
 //Recipients
//  $mail->setFrom('from@example.com', 'Mailer');
//  $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
 // $mail->addAddress('ellen@example.com');               //Name is optional
 // $mail->addReplyTo('info@example.com', 'Information');
 // $mail->addCC('cc@example.com');
 // $mail->addBCC('bcc@example.com');

 //Attachments
 // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
 // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

 //Content
//  $mail->isHTML(true);                                  //Set email format to HTML
//  $mail->Subject = 'Encrypted Message | '.$_SERVER['SERVER_NAME'];
//  $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//  $mail->send();