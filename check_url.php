<?php

$url = str_replace ("/", "", $_SERVER['REQUEST_URI']);

require("lib/db.php");

$mysql_connect = new mysqli(
    $host,
    $user,
    $pass,
    $db_name
);
mysqli_set_charset($mysql_connect, "utf8");

$result = $mysql_connect->query("SELECT `point` FROM `shorten urls` WHERE `url`='$url'");

mysqli_close($mysql_connect);

$result = mysqli_fetch_array($result);

if ($result == null)
{
    include_once("404.php");
    
    exit();
}
else
{
    header("Location: https://" . $result["point"]);
}

?>