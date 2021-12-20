<?php

$point = $_POST["point"];

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

$result = $mysql_connect->query("INSERT INTO `shorten urls` (`url`, `point`) VALUES ('$random_url', '$point')");

mysqli_close($mysql_connect);

echo "<span>Shorten URL succesfully created.<p>https://url.hzswdef.xyz/" . $random_url . "</p></span>";

?>