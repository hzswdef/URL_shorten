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

if ((strlen($point) <= 3) || (strpos($point, ".") == false))
{
    echo "Invalid URL.";
    
    exit();
}

require("lib/db.php");

$mysql_connect = new mysqli(
    $host,
    $user,
    $pass,
    $db_name
);
mysqli_set_charset($mysql_connect, "utf8");

$check_token = $mysql_connect->query("SELECT `token` FROM `tokens` WHERE `token`='$token'");

$check_token = mysqli_fetch_array($check_token);

if ($check_token == null)
{
    echo "Invalid TOKEN. Access denied.";
    
    exit();
}

function create_random_url($mysql_connect)
{
    $url = substr(md5(mt_rand()), 0, 5);
    
    $check = $mysql_connect->query("SELECT * FROM `shorten urls` WHERE `url`='$url'");
    $check = mysqli_fetch_array($check);
    
    if ($check !== null)
    {
        create_random_url($mysql_connect);
    }
    
    return $url;
}

$random_url = create_random_url($mysql_connect);

$mysql_connect->query("INSERT INTO `shorten urls` (`url`, `point`, `token`) VALUES ('$random_url', '$point', '$token')");
$mysql_connect->query("INSERT INTO `tokens` (`used`) VALUES ('used'='used'+1) WHERE `token`='$token'");

mysqli_close($mysql_connect);

echo "{ \"url\": \"https://url.hzswdef.xyz/$random_url\" }";

?>