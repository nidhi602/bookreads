<?php

    session_start();

    if(!isset($_SESSION['username']))
    {
        header("Location: login.php");
        exit();
    }
    require 'includes\db_conn.php';

?>

<!DOCTYPE html>
<html>
    <head><title>Profile | Bookreads</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="CSS/profile.css">
    <link rel="stylesheet" href="CSS/footer.css">
</head>
</body>
<div class="page">
    <?php include_once 'header.html'; ?>
    <main>
        <div class="register">
        <div class="card">
        <?php
            if(isset($_GET['error']))
            {
                if($_GET['error'] == "emptyfields")
                    echo '<p class="error" style="color:red;">Fill in all the fields!</p>';
                else if($_GET['error'] == "invalidname")
                    echo '<p class="error" style="color:red; ">Invalid name!<br>Name must contain a-z and A-Z characters.</p>';
                else if($_GET['error'] == "invalidage")
                    echo '<p class="error" style="color:red; ">Invalid age!<br>Age must be an integer &gt 0</p>';
                else if($_GET['error'] == "invalidmail")
                    echo '<p class="error" style="color:red;">Invalid e-mail address!</p>';
                else if($_GET['error'] == "invalidphone")
                    echo '<p class="error" style="color:red;">Invalid phone number!</p>';
                else if($_GET['error'] == "invalidusername")
                    echo '<p class="error" style="color:red;">Invalid username!<br>Username must only contain a-z, A-Z, and 0-9 characters.</p>';
                else if($_GET['error'] == "usernametaken")
                    echo '<p class="error" style="color:red;">Username already exists!</p>';
            }
            else if(isset($_GET['result']))
            {
                if($_GET['result'] == 'success')
                    echo '<p class="error" style="color:green;">Profile updated!</p>';
            }

            $sql = "SELECT * FROM user WHERE username = ?;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql))
            {
                header("Location: ../signup.php?error=sqlerror");
                exit();	
            }
            else
            {
                mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $user = mysqli_fetch_assoc($result);
        ?>
        
        <form action= "includes/updateprofile_inc.php" method="post">
            <div class="lab"><label for="name"><b>Name</b></label></div>
            <input type="text" name="name" value="<?php echo $user['name'];?>" required>
            <br>
            <div class="lab"><label for="age"><b>Age</b></label></div>
            <input type="number" name="age" value="<?php echo $user['age'];?>" required>
            <br>
            <div class="lab"><label for="gender"><b>Gender</b></label></div>
            <div class="radio">
                <table>
                    <tr>
                        <td><input type="radio" id="male" name="gender" value="M" <?php echo ($user['gender'] == 'M')? 'checked':'';?>>
                        <label for="male">Male</label></td>
                        
                        <td><input type="radio" id="female" name="gender" value="F" <?php echo ($user['gender'] == 'F')? 'checked':'';?>>
                        <label for="female">Female</label></td>
                        
                        <td><input type="radio" id="other" name="gender" value="O" <?php echo ($user['gender'] == 'O')?' checked':'';?>>
                        <label for="Other">Other</label></td>
                    </tr>
                </table>
            </div>
            <br>
            <div class="lab"><label for="mail"><b>Email Address</b></label></div>
            <input type="text" name="mail" value="<?php echo $user['email'];?>" required>
            <br>
            <div class="lab"><label for="user"><b>User Name</b></label></div>
            <input type="text" name="user" value="<?php echo $user['username'];?>" disabled>
            <br>
            <div class="buttons">
                <p><button class="update" type="submit" name="update">Update</button></p>
            </div>

            <div class="buttons">
                <p><button class="rpwd" name="rpwd"><a href="pwdreset.php">Change Password</a></button>
            </div>
            </form>
            <!-- <div class="del">
                <p><button class="delete" name="delete" onclick="confirmDelete()">Delete Account</button>
            </div> -->
        <?php } ?>
        </div>
        </div>
    </main>
    <script>
        function confirmDelete()
        {
            let confirmAction = confirm("Permanently delete your account?\nCaution - All your data will be lost if you press 'OK'!");
            if(confirmAction)
            {
                let url = 'includes/deleteaccount.php';
                window.location.replace(url);
            }            
        }
    </script>
    <?php include_once 'footer.html'; ?>
</div>
</body>
</html>