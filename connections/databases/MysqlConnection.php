<?php
namespace connections\database;
require __DIR__.'/../../config/DatabaseConfig.php';
use \config\DatabaseConfig;

class MysqlConnection {

    private $db_host;
    private $db_user;
    private $db_password;
    private $db_name;
    private $connector = null;

    public function connect($db_host=NULL, $db_user=NULL, $db_password=NULL, $db_name=NULL){
        if($db_host)
            $this->db_host = $db_host ;
        else $this->db_host = DatabaseConfig::$HOST;

        if($db_user)
            $this->db_user = $db_user ;
        else $this->db_user = DatabaseConfig::$USER;

        if($db_password)
            $this->db_password = $db_password ;
        else $this->db_password = DatabaseConfig::$PASSWORD;

        if($db_name)
            $this->db_name = $db_name ;
        else $this->db_name = DatabaseConfig::$NAME;
        $this->connector = mysqli_connect($this->db_host, $this->db_user, $this->db_password, $this->db_name);
        if (mysqli_connect_error()) {
            throw new Exception("Mysql connection failed: " . mysqli_connect_error(), 1);
            exit();
        }
        return $this->connector;
    }
}

?>
