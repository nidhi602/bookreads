<?php

    $server = 'localhost';
    $username = 'root';
    $password = 'admin';
    $database = 'bookreads';

    $conn = mysqli_connect($server, $username, $password, $database);

    if(!$conn)
        die("<br>Connection Failed : ".mysqli_connect_error());
    // else
    //     echo "Connection succesful!";

?>
