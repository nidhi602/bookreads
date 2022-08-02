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
    <head><title>Signup | Bookreads</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="CSS/signup.css">
	<link rel="stylesheet" href="CSS/footer.css">
</head>
<body>
<div class="page">
	<main>
		<div class="main" id="navbar">
			<div class="header" id="logo">
				<a href="explore.php"><img src="img/BookReads1.png" height="100em"></a>
			</div>
			<a href="login.php"><b>Login</b></a>
		</div>
		
		<div class="register">
			<div class="card">
				<?php
					if(isset($_GET['error']))
					{
						if($_GET['error'] == "emptyfields")
							echo '<p style="color:red;">Fill in all the fields!</p>';
						else if($_GET['error'] == "invalidname")
							echo '<p style="color:red; ">Invalid name!<br>Name must only contain a-z and A-Z characters.</p>';
						else if($_GET['error'] == "invalidage")
							echo '<p style="color:red; ">Invalid age!<br>Age must be an integer &gt 0</p>';
						else if($_GET['error'] == "invalidmail")
							echo '<p style="color:red;">Invalid e-mail address!</p>';
						else if($_GET['error'] == "invalidusername")
							echo '<p style="color:red;">Invalid username!<br>Username must only contain a-z, A-Z, and 0-9 characters.</p>';
						else if($_GET['error'] == "invalidpassword")
							echo '<p style="color:red;">Invalid password!<br>Password must be 8-15 characters long and must only contain a-z, A-Z, 0-9, @, *, # characters.</p>';
						else if($_GET['error'] == "usernametaken")
							echo '<p style="color:red;">Username already exists!</p>';
					}
				?>
				<form action= "includes/signup_inc.php" method="post">
					<div class="lab"><label for="name"><b>Name</b></label></div>
					<input type="text" name="name" required>
					<br>	
					<div class="lab"><label for="age"><b>Age</b></label></div>
					<input type="number" name="age" required>
					<br>
					<div class="lab"><label for="gender"><b>Gender</b></label></div>
					<div class="radio">
						<table>
							<tr>
							<td><input type="radio" id="male" name="gender" value="M" checked>
							<label for="male">Male</label></td>
							<td><input type="radio" id="female" name="gender" value="F">
							<label for="female">Female</label></td>
							<td><input type="radio" id="other" name="gender" value="O">
							<label for="Other">Other</label></td>
							</tr>
						</table>
					</div>
					<br>
					<div class="lab"><label for="mail"><b>Email Address</b></label></div>
					<input type="text" name="mail" required>
					<br>
					<!-- <div class="lab"><label for="phone"><b>Contact</b></label></div>
					<input type="text" name="phone" required>
					<br> -->
					<div class="lab"><label for="user"><b>User Name</b></label></div>
					<input type="text" name="user" required>
					<br>
					<div class="lab"><label for="pwd"><b>Password (8-15 characters long)</b></label></div>
					<input type="password" name="pwd" required><br><br>
					<button class="button" type="submit" name="signup">Sign Up</button>
				</form>
				<p>Already a Member? <a href="login.php">Login!</a></p>
			</div>
		</div>
	</main>
	<?php include_once 'footer.html'; ?>
</div>
</body>
</html>