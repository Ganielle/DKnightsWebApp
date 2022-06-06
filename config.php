<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "wordlabdatabase";

$conn = mysqli_connect($hostname, $username, $password, $database) or die("Database connection failed");

$base_url = "http://localhost/wordlabwebapp/loginSystem/";
$my_email = "";

?>