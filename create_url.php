<span>

<?php

require_once "lib/API/API.class.php";

if (!isset($_POST["point"]))
{
    die("Missing URL.");
}

$point = $_POST["point"];

$api = new api(null);
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

// Return response with created url
echo "Shorten URL succesfully created.<p>" . $url . "</p>";

?>

</span>