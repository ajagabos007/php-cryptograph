<?php
ini_set('display_errors', 1);
include '../vendor/autoload.php';
session_start();
use  \phpseclib3\Crypt\DES;

class DesFactory extends Des {
    public $cipher_text;
    public $plain_text;
    public function getKey(){
        return $this->key;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_POST['DES_operation']?? null === null) {
    
    $response = array(
        "status" => 422,
        "message" => "Unprocessable data",
    );

    try {
        $key = $_POST["key"] ?? '12345678';
        $DES_operation = $_POST['DES_operation']?? null;
        $_SESSION['DES_operation'] = $DES_operation;

        if($DES_operation == 'encryption'){
            unset($_SESSION['plain_text']);
            $des = new DesFactory('ctr');
            $des->setIV($key);
            $des->setKey($key);

            $plain_text = $_POST["plain_text"] ?? 'random plain text';
            $des->cipher_text =  $des->encrypt($plain_text);
            $_SESSION['DES'] = serialize($des);

            $_SESSION['cipher_text'] = $des->cipher_text;
            $response = array(
                "status" => 200,
                "message" => "plain text encrypted successfully",
            );
        }

        else {
            if(!isset($_SESSION['DES'])){
                throw new Exception("Please perform des encryption first before decryption", 1);
            }

            $des = unserialize($_SESSION['DES']);
            $cipher_text = $_POST["cipher_text"] ?? 'random cipher text';
            $des_cipher_text = $_POST['des_cipher_text']?? null;
            
            if($des_cipher_text===null){
                unset($_SESSION['plain_text']);
              throw new Exception("Please perform des encryption first before decryption", 1);
            }

            if(!($des_cipher_text === $cipher_text) || !($key === $des->getKey()))
            {
                unset($_SESSION['plain_text']);
                throw new Exception("Wrong key or cipher text", 1);
            }

            $_SESSION['plain_text']  =   $des->decrypt($des->cipher_text);

            $response = array(
                "status" => 200,
                "message" => "Cipher text decrypted successfully",
            );

        }         
          
        echo json_encode($response);
        exit();

    } catch (Exception $th) {
        if( $_SESSION['DES_operation'] == 'encryption')
            unset($_SESSION['plain_text']);
        $_SESSION['error'] = $th;
        $response = array(
            "status" => 422,
            "message" => "DES API call Error",
        );
        echo json_encode($response);
        exit();
    }
   
}
// Redirect back to index page
header('location: ../');

exit();
