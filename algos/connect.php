<?php
$dbhost = 'localhost';
$username = 'root';
$password = '*Bettingraja123#';
$dbname = 'BettingRaja';
$conn = mysqli_connect("$dbhost", "$username", "$password", "$dbname");
if ($conn->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
