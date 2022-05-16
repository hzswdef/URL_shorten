<?php

// Fetch unique code from requested URL
$url = str_replace("/", "", $_SERVER['REQUEST_URI']);

// Connect to database
require("lib/db.php");
$mysql_connect = new mysqli(
    $host,
    $user,
    $pass,
    $db_name
);
mysqli_set_charset($mysql_connect, "utf8");

// Trying to fetch entry with shorten URL
$result = $mysql_connect->query("SELECT `point` FROM `shorten urls` WHERE `url`='$url'");
$result = mysqli_fetch_array($result);

mysqli_close($mysql_connect);

if ($result == null)
{  // Redirect user to 404 page
    include_once("404.php");
    
    exit();
}
else
{  // Redirect user to requested URL
    header("Location: https://" . $result["point"]);
}

?>