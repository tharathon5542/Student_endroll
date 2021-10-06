<?php
    $serverName = "localhost";
    $userName = "root";
    $password = "";
    $dbname = "registration";

    //create connection
    $conn = mysqli_connect($serverName, $userName, $password, $dbname);
    // Change character set to utf8
    mysqli_set_charset($conn,"utf8");
    
    //check connection
    if(!$conn){
        die("Connection fail" . mysqli_connect_error());
    }

?>