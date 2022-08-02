<?php

    session_start();

    if(!isset($_SESSION['username']))
    {
        header("location: index.php");
        exit();
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password | Bookreads</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="CSS/pwdreset.css">
    <link rel="stylesheet" href="CSS/footer.css">
</head>
<body>
    <div class='page'>
        <?php include_once 'header.html'; ?>
        <div class="register">
            <div class="card">
            <?php
                    if(isset($_GET['error']))
                    {
                        if($_GET['error'] == "emptyfields")
                            echo '<p style="color:red;">Fill in all 3 fields!</p>';
                        else if($_GET['error'] == "invalidoldpassword")
                            echo '<p style="color:red;">Invalid old password!</p>';
                        else if($_GET['error'] == "invalidnewpassword")
                            echo '<p style="color:red;">Invalid new password!<br>Password must be 8-15 characters long and must only contain a-z, A-Z, 0-9, @, *, # characters.</p>';
                        else if($_GET['error'] == "newpasswordsdonotmatch")
                            echo '<p style="color:red;">New passwords do not match!</p>';
                    }
                    else if(isset($_GET['reset']))
                    {
                        if($_GET['reset'] == "success")
                            echo '<p style="color:green;">Reset successfully!</p>';
                    }
                ?>
                <form action= "includes/pwdreset_inc.php" method="post">
                    <div class="lab"><label for="old"><b>Old Password</b></label><br></div>
                    <input type="password" name="old" required>
                    <br>
                    <div class="lab"><label for="new1"><b>New Password</b></label><br></div>
                    <input type="password" name="new1" required>
                    <div class="lab"><label for="new2"><b>Confirm Password</b></label><br></div>
                    <input type="password" name="new2" required>
                    <p><button class="button" type="submit" name="reset">Reset</button></p>
                </form>
            </div>
        </div>
        <?php include_once 'footer.html'; ?>
    </div>
</body>
</html>