<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "perpus_aliyam";

$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
?>
