<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "crud_app";

$connect = mysqli_connect($servername, $username, $password, $database);



if ($connect->connect_error) {
    die('connection error :' + $connect->connect_error);
}

?>