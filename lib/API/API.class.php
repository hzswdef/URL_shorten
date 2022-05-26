<?php

require_once "lib/API/API_DB.class.php";

class API extends API_DB
{
    private $token;
    
    public function __construct($token)
    {
        parent::__construct();
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
        $curlInit = curl_init($point);
        
        curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
        curl_setopt($curlInit,CURLOPT_HEADER,true);
        curl_setopt($curlInit,CURLOPT_NOBODY,true);
        curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
    
        $response = curl_exec($curlInit);
        curl_close($curlInit);
        
        if ($response == false)
        {
            //header("HTTP/1.1 400 Bad Request");
            
            die("URL not responding.");
        }
        
        if (strlen($point) > 256) {
            //header("HTTP/1.1 400 Bad Request");
            
            die("URL too long.");
        }
    }
}

?>