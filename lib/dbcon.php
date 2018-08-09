<?php
/* Database connection start */
$servername = "localhost";
$username = "root";
$password = "9kali9=81ub";
// $password = "Password1";
$dbname = "putriwardrobe";
// $dbname = "datatable";
// $dbname = "datatables_demo";
// $dbname = "test";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
// print_r($conn);
// exit();
/* Database connection end */
?>
