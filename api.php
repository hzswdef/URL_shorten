<?php

require_once "lib/MySQL.class.php";

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
            header("HTTP/1.1 403 Internal Server Error");
            
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
    public function insert_new_entry(string $url, string $point, string $token)
    {
        $this->conn->query("INSERT INTO `shorten urls` (`url`, `point`, `token`) VALUES ('$url', '$point', '$token')");
        
        self::update_token_uses($token);
    }
    
    private function update_token_uses(string $token)
    {
        $this->conn->query("UPDATE `tokens` SET `used`=`used`+1 WHERE `token`='$token'");
    }
}

class API extends API_DB
{
    private $token;
    
    public function __construct(string $token)
    {
        parent::__construct();
        parent::check_token($token);
        $this->token = $token;
    }
    
    public function create_url(string $point)
    {
        $rand_chars = substr(md5(mt_rand()), 0, 5);
        
        if ($this->check_url_exists($rand_chars)) {
            return self::create_url();
        }
        $this->insert_new_entry($rand_chars, $point, $this->token);
        
        return $rand_chars;
    }
    
    public function point_validation(string $point)
    {
        if(!$socket =@ fsockopen($point, 80, $errno, $errstr, 30)) {
            header("HTTP/1.1 400 Bad Request");
            
            die("URL not responding.");
        }
        fclose($socket);
        
        if (strlen($point) > 256) {
            header("HTTP/1.1 400 Bad Request");
            
            die("URL too long.");
        }
    }
}


if (!isset($_GET["token"]))
{
    echo "No token specified.";
    exit();
}
if (!isset($_GET["url"]))
{
    echo "Missing URL.";
    exit();
}

$token = $_GET["token"];
$point = $_GET["url"];


$api = new API($token);
$api->point_validation($point);
$short_url = $api->create_url($point);
$api->close();


function get_server_protocol() {
    if (isset($_SERVER['HTTPS']) && 
        ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
        $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') 
    {
        return 'https://';
    }
    else
    {
        return 'http://';
    }
}

// prepare link to return
$url = get_server_protocol() . $_SERVER['HTTP_HOST'] . '/' . $short_url;


// Return JSON response
echo "{ \"url\": \"$url\" }";

?>