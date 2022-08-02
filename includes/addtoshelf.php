<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        header("location: ../index.php");
        exit();
    }

    require 'db_conn.php';

    $username = $_SESSION['username'];
    $book_id = $_GET['book_id'];
    $shelf = $_GET['shelf'];
    $rating = null;

    $sql = "SELECT * FROM user_book WHERE username = ? AND book_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../explore.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, 'ss', $username, $book_id);
        mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if (mysqli_num_rows($result) > 0) 
        {
            $record = mysqli_fetch_assoc($result);
            $rating = $record['rating'];
            if($record['shelf'] == $shelf)
            {
                header("location: ".$_SERVER['HTTP_REFERER']."?result=duplicate");
                exit();
            }
            else
            {
                $sql = "DELETE FROM user_book WHERE book_id=? AND username = ?;";
                $stmt = mysqli_stmt_init($conn);
    
                if(!mysqli_stmt_prepare($stmt, $sql))
                {
                    header("location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                    exit();
                }
                else
                {
                    mysqli_stmt_bind_param($stmt, 'ss', $book_id, $username);
                    if(!mysqli_stmt_execute($stmt))
                    {
                        header("location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                        exit();
                    }
                }
            }
        }
        $sql = "INSERT into user_book (username, book_id, shelf, rating) values (?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql))
        {
            header("location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
        }
        else
        {
            mysqli_stmt_bind_param($stmt, 'ssss', $username, $book_id, $shelf, $rating);
            mysqli_stmt_execute($stmt);
            header("location: ".$_SERVER['HTTP_REFERER']."?result=added");
        }
    }

    mysqli_stmt_close($stmt);
	mysqli_close($conn);
?>