<?php 
namespace config;
// <!-- Email Settings  -->
class MailConfig{
    static $HOST       = '';            //Set the SMTP server to send through
    static $USERNAME   = '';            //SMTP username
    static $PASSWORD   = '';            //SMTP password
    static $PORT       = 2525;          //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    static $SMTP_DEBUG = false;         //Enable verbose debug output
    static $IS_SMTP = true;             //Send using SMTP
    static $SMTP_AUTH   = true;         //Enable SMTP authentication
    static $SMTP_SECURE = false ;       //Enable implicit TLS encryption
}
?>