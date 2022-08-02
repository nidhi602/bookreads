<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        header("Location: ../index.php");
        exit();
    }

    $username = $_SESSION['username'];

    require 'db_conn.php';

    $sql = "DELETE FROM user WHERE username=?;";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../updateprofile.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, 's', $username);
        if(!mysqli_stmt_execute($stmt))
        {
            header("location: ../updateprofile.php?error=sqlerror");
            exit();
        }
        else
        {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            session_unset();
            session_destroy();
            header("location: ../index.php");
            exit();
        }
    }
?>