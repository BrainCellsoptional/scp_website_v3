<?php
    include "credentials.php";
    //Database Connection
    $connection = new mysqli("localhost", $user, $password, $database);
    
    // Select All Records From Table
    $all_records = $connection->prepare("select * from scp_data");
    $all_records->execute();
    $result = $all_records->get_result();
?>