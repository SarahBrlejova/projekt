<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "simple_house";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Napojenie zlyhalo: " . $conn->connect_error);
}

?>

