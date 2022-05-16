<?php

if (!isset($_GET["token"]))
{
    echo "Unauthorized token. Access denied.";
    exit();
}
if (!isset($_GET["url"]))
{
    echo "Missing URL.";
    exit();
}

$token = $_GET["token"];
$point = $_GET["url"];

// Basic url check if he is valid
if ((strlen($point) <= 3) || (strpos($point, ".") == false))
{
    echo "Invalid URL.";
    exit();
}

// Connect to database
require("lib/db.php");
$mysql_connect = new mysqli(
    $host,
    $user,
    $pass,
    $db_name
);
mysqli_set_charset($mysql_connect, "utf8");

// BEGIN | Check given token to authorize system
$check_token = $mysql_connect->query("SELECT `token` FROM `tokens` WHERE `token`='$token'");
$check_token = mysqli_fetch_array($check_token);

if ($check_token == null)
{
    echo "Invalid TOKEN. Access denied.";
    exit();
}
// END

// Create unique random chars
function create_random_url($mysql_connect)
{
    $rand_chars = substr(md5(mt_rand()), 0, 5);
    
    // BEGIN | Check if entry with randomed code 
    $check = $mysql_connect->query("SELECT * FROM `shorten urls` WHERE `url`='$rand_chars'");
    $check = mysqli_fetch_array($check);
    
    // Invoke this func again if entry with $rand_chars already exists in DB
    if ($check !== null)
    {
        return create_random_url($mysql_connect);
    }
    // END
    
    return $rand_chars;
}
$random_url = create_random_url($mysql_connect);

// Add new "short url" entry to DB
$mysql_connect->query("INSERT INTO `shorten urls` (`url`, `point`, `token`) VALUES ('$random_url', '$point', '$token')");

// Update token usage count in DB
$mysql_connect->query("UPDATE `tokens` SET `used`=`used`+1 WHERE `token`='$token'");

mysqli_close($mysql_connect);

// Return repsonse with JSON data
echo "{ \"url\": \"https://url.hzswdef.xyz/$random_url\" }";

?>