<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'libas_e_khas';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
