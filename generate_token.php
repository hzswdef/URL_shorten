<?php

require_once "lib/DB/MySQL.class.php";

class GENERATE_API extends MySQL
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function gen_new_token()
    {
        $token = substr(md5(mt_rand()), 0, 16);
        
        if ($this->check_token_exists($token)) {
            return $this->gen_new_token();
        }
        $this->save_token($token);
        
        return $token;
    }
    
    private function check_token_exists(string $token)
    {
        $res = $this->conn->query("SELECT * FROM `tokens` WHERE `token`='$token'");
        
        if (mysqli_fetch_array($res) !== null) {
            return true;
        }
        return false;
    }
    
    private function save_token(string $token)
    {
        $this->conn->query("INSERT INTO `tokens` (`token`, `used`) VALUES ('$token', 0)");
    }
}

$gen_api = new GENERATE_API();
$token = $gen_api->gen_new_token();

die($token);

?>