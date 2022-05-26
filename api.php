<?php

require_once "lib/API/API.class.php";

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
$api->check_token($token);
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