<?php
    session_start();

    if(!isset($_SESSION['username']))
    {
        header("location: index.php");
        exit();
    }

    require 'db_conn.php';

    $username = $_SESSION['username'];
    $book_id = $_GET['book_id'];
    $rating = $_GET['rating'];

    $sql = "UPDATE user_book SET rating = ? WHERE book_id = ? AND username = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../mybooks.php?error=sqlerror");
    }
    else
    {
        mysqli_stmt_bind_param($stmt, 'sss', $rating, $book_id, $username);
        if(!mysqli_stmt_execute($stmt))
            header("location: ../mybooks.php?error=sqlerror");
        else
            header("location: ../mybooks.php?result=updated");
    }

    mysqli_stmt_close($stmt);
	mysqli_close($conn);
?>