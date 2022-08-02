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
    <head><title>Login | Bookreads</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="CSS/login.css">
    <link rel="stylesheet" href="CSS/footer.css">
</head>
<body>
    <div class="page">
        <div id="navbar">
            <div class="header" id="logo">
                <a href="explore.php"><img src="img/BookReads1.png" height="100em"></a>
            </div>
            <a href="signup.php"><b>Signup</b></a>
        </div>
        <main>
            <div class="card">
                <?php 
                    if(isset($_GET['error']))
                    {
                        if($_GET['error'] == "emptyfields")
                            echo '<p style="color:red;">Fill in both the fields!</p>';
                        else if($_GET['error'] == "nouser")
                            echo '<p style="color:red;">Invalid username and/or password!</p>';
                    }
                ?>
                <form method="post" action="includes/login_inc.php">
                    <div class="lab"><label for="user"><b>User Name</b></label><br></div>
                    <input type="text" name="user" required>
                    <br>
                    <div class="lab"><label for="pwd"><b>Password</b></label><br></div>
                    <input type="password" name="pwd" required>
                    <p><button class="button" type="submit" name="login">Login</button></p>
                </form>
                <p>Not a Member? <a href="signup.php">Signup!</a></p>
            </div>
        </main>
        <?php include_once 'footer.html'; ?>
    </div>
</body>
</html>