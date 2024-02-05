<?php

function connectDb() {
    $host = "localhost";
    $username = "ali";
    $password = "ali";
    $database = "geobrains";
    $conn = new mysqli($host, $username, $password, $database);
    return $conn;
}
$connation = connectDb();
?>