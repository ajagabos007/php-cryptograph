<?php
    ini_set('display_errors', true);
    require __DIR__.'/../vendor/autoload.php';
    require __DIR__.'/../connections/databases/MysqlConnection.php';
    use \connections\database\MysqlConnection;
   

    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        try {

            $key = $_POST['key']?? null;
            $uuid = $_POST['uuid']?? null;

            // Create Database Coonection
            $mysql_db = new MysqlConnection();
            $mysql_con = $mysql_db->connect();
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
       
            // get the operation log to save the mailable 
            $sql_query = "SELECT * FROM `operational_logs` WHERE `uuid` = '$uuid' AND `des_key` = '$key' LIMIT 1 ;";
            $result = $mysql_con->query($sql_query);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                $operational_log_des_text=  $row["des_text"];
                }
            } else {
                throw new Exception("Decryption failed, incorrect key. ");
            }
            
            $response = array(
                "status" => 200,
                "message" => "Mail decrypted successfully",
                'des_text' => $operational_log_des_text,
            );
            echo json_encode($response);
            exit();

        }  catch (\Throwable $th) {
            $response = array(
                "status" => 422,
                "message" => "Decryption operation failed <br/>".$th->getMessage(),
            );
            echo json_encode($response);
            exit();
        }
       
    }
?>



