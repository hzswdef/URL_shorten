<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/DB/MySQL.class.php";

class API_DB extends MySQL
{
    public function __construct() {
        parent::__construct();
    }
    
    // check if token exists in db
    public function check_token(string $token)
    {
        $res = $this->conn->query("SELECT * FROM `tokens` WHERE `token`='$token'");
        
        if (mysqli_fetch_array($res) == null) {
            //header("HTTP/1.1 403 Internal Server Error");
            
            die("Unauthorized token. Access denied.");
        }
    }
    
    // check if id for new short url already exists in db
    public function check_url_exists(string $url)
    {
        $res = $this->conn->query("SELECT * FROM `shorten urls` WHERE `url`='$url'");
        
        if (mysqli_fetch_array($res) !== null) {
            return true;
        }
        return false;
    }
    
    // add new short url entry to db
    public function insert_new_entry(string $url, string $point, $token)
    {
        $this->conn->query("INSERT INTO `shorten urls` (`url`, `point`, `token`) VALUES ('$url', '$point', '$token')");
        
        if ($token != null) {
            self::update_token_uses($token);
        }
    }
    
    private function update_token_uses(string $token)
    {
        $this->conn->query("UPDATE `tokens` SET `used`=`used`+1 WHERE `token`='$token'");
    }
}

?>