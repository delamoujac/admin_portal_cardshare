<?php
$servername = "localhost";
$username = "galaappc_galabackend";
$password = "9f!t342xN$$1.";
$dbname = "galaappc_galabackend";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error($sql));
}
//echo "hello";
?>