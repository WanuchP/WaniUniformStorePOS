<?php
$sname= "127.0.0.1";
$uname= "t66g1";
$password = "t66g1";
$db_name = "t66g1";
$conn = mysqli_connect($sname, $uname, $password, $db_name);
if (!$conn) {
    echo "Connection failed!";
}
