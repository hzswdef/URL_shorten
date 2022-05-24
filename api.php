<?php

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

class MySQL
{
    private $conn; // database connection
    
    public function __construct() {
        self::db_connect();
    }
    
    // connect to database
    private function db_connect()
    {
        // database config
        require("lib/db.php");
        
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $this->conn = new mysqli(
                $host,
                $user,
                $pass,
                $db_name
            );
        } catch (Exception $e) {
            header("HTTP/1.1 500 Internal Server Error");
            
            die("Troubles with database, try later.");
        }
        
        $this->conn->set_charset("utf8");
    }
    
    public function close()
    {
        mysqli_close($this->conn);
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

class API extends MySQL
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
        if (!preg_match("/^((https|http|ftp)\:\/\/)?([a-z0-9A-Z]+\.[a-z0-9A-Z]+\.[a-z0-9A-Z]+\.[a-zA-Z]{2,4}|[a-z0-9A-Z]+\.[a-z0-9A-Z]+\.[a-zA-Z]{2,4}|[a-z0-9A-Z]+\.[a-zA-Z]{2,4})$/i", $point)) {
            header("HTTP/1.1 400 Bad Request");
            
            die("Bad URL.");
        }
        
        if(!$socket =@ fsockopen($point, 80, $errno, $errstr, 30)) {
            header("HTTP/1.1 400 Bad Request");
            
            die("URL not responding.");
        }
        fclose($socket);
    }
}

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

$url = get_server_protocol() . $_SERVER['HTTP_HOST'] . '/' . $short_url;

// Return response with JSON data
echo "{ \"url\": \"$url\" }";

?>