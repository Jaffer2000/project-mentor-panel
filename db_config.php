<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "innovatie";

$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
    echo "Niet gelukt: " . mysqli_connect_error();
} else {
    echo "";
}
?>


