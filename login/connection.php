<?php
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'club_management';

    $conn = NEW  mysqli($db_host,$db_user,$db_pass,$db_name);

    if(!$conn){
        die("Connection Failed". $conn->connect_error);
    }
?>