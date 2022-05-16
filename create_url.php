<?php

$point = $_POST["point"];

// Basic url check if he is valid
if ((strlen($point) <= 3) || (strpos($point, ".") == false))
{
    echo "<span class='error'>Invalid URL.</span>";
    exit();
}

// Remove "https://" or "http://" from $point
$point = str_replace("https://", "", $point);
$point = str_replace("http://", "", $point);

// Connect to database
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
    $rand_chars = substr(md5(mt_rand()), 0, 5);
    
    // BEGIN | Check if entry with randomed code 
    $check = $mysql_connect->query("SELECT * FROM `shorten urls` WHERE `url`='$rand_chars'");
    $check = mysqli_fetch_array($check);
    
    // invoke this func again if entry with $rand_chars already exists in DB
    if ($check !== null)
    {
        return create_random_url($mysql_connect);
    }
    // END
    
    return $rand_chars;
}
$random_url = create_random_url($mysql_connect);

// Add new "short url" entry to DB
$result = $mysql_connect->query("INSERT INTO `shorten urls` (`url`, `point`, `token`) VALUES ('$random_url', '$point', Null)");

mysqli_close($mysql_connect);

// Return response with created url
echo "<span>Shorten URL succesfully created.<p>https://url.hzswdef.xyz/" . $random_url . "</p></span>";

?>