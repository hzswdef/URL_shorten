<?php

class MySQL
{
    protected $conn; // database connection
    
    public function __construct() {
        $this->conn = self::db_connect();
    }
    
    // connect to database
    private static function db_connect()
    {
        // database config
        require($_SERVER['DOCUMENT_ROOT'] . "/lib/DB/db.php");
        
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $conn = new mysqli(
                $host,
                $user,
                $pass,
                $db_name
            );
        } catch (Exception $error) {
            header("HTTP/1.1 500 Internal Server Error");
            
            die("Troubles with database, try later.\n\n$");
        }
        
        $conn->set_charset("utf8");
        
        return $conn;
    }
    
    public function close()
    {
        mysqli_close($this->conn);
    }
}

?>