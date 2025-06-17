<?php

$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "test_db";

$conn = mysqli_connect(hostname: $sname, username: $uname, password: $password, database: $db_name);

if (!$conn) {
    echo "Connection failed!";
    exit();
}
?>
