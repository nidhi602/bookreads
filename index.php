<?php

    session_start();
    if(isset($_SESSION['username']))
    {
        header("Location: explore.php");
        exit();
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Bookreads</title>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="CSS/index.css">
    <!-- <style>
        #bg {
            background-image: url("img/Poster2.png");
            background-size: 100% 100vh;
        }
    </style> -->
</head>
<body>
    <div id="navbar">
        <a href="signup.php"><b>Signup</b></a>
        <a href="login.php"><b>Login</b></a>
    </div>

    <div id="bg"> 
        <div id="section1">
            <img src="img\BookReads.png" height="250px">
            <div id="text">
                <h1>A way to keep track of all your beloved books</h1>
                <div id ="button">
                    <form action="login.php">
                        <button id="join" type="submit">Join Now</button>
                    </form>
                </div>
                <p><br>Bookreads provides the facility to organize your books on shelves and discover new books.<br>It helps you manage your reading list and provide facility to rate a book and also displays<br>average rating for each book.</p>

            </div>
        </div>
    </div>
</body>
</html>