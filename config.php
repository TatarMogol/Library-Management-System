<?php
$host   = "localhost";
$user   = "root";
$pass   = "";
$dbname = "library_db";
$port   = 3306;

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}