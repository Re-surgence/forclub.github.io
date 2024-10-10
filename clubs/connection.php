<?php
    $conn = new mysqli('localhost','root','','club_management');

    if(!$conn){
        die("Connection Failed". $conn->connect_error);
    }
?>