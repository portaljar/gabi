<?php
	$servername = "sql213.infinityfree.com";
	$username = "if0_39478683";
	$password = "casalola25";
	$dbname = "if0_39478683_esp12";
  
   
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    //Check connection
    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT * FROM ac_estado";
mysqli_set_charset($conn, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($conn, $sql)) die();

$estado = array(); //creamos un array


$row = mysqli_fetch_array($result);
?>
