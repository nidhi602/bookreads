<?php

if(isset($_POST['signup']))
{
	require 'db_conn.php';

	$name = $_POST['name'];
	$age = $_POST['age'];
    $gender = $_POST['gender'];
	$email = $_POST['mail'];
	$username = $_POST['user'];
	$password = $_POST['pwd'];

	if(empty($name) || empty($age) || empty($email) || empty($username) || empty($password))
	{
		header("Location: ../signup.php?error=emptyfields&name=".$name."&age=".$age."&mail=".$email."&user=".$username);
		exit();
	}
	if(!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $name))
	{
		header("Location: ../signup.php?error=invalidname&mail=".$email."&user=".$username);
		exit();

	}
    else if($age <= 0)
    {
        header("Location: ../signup.php?error=invalidage&name=".$name."&mail=".$email."&user=".$username);
		exit();   
    }
	else if(!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+(\.[a-zA-Z]{2,5})+$/",$email))
	{
		header("Location: ../signup.php?error=invalidmail&name=".$name."&age=".$age."&user=".$username);
		exit();
	}
	// else if(!preg_match("/^[1-9]{1}[0-9]{6,10}$/", $phonenumber))
	// {
	// 	header("Location: ../signup.php?error=invalidphone&name=".$name."&age=".$age."&mail=".$email."&user=".$username);
	// 	exit();
	// }
	else if(!preg_match("/^[a-zA-Z][a-zA-Z0-9]*$/", $username))
	{
		header("Location: ../signup.php?error=invalidusername&name=".$name."&age=".$age."&mail=".$email);
		exit();
	}
	else if(!preg_match("/^([a-zA-Z0-9@*#]{8,15})$/", $password))
	{
		header("Location: ../signup.php?error=invalidpassword&name=".$name."&age=".$age."&mail=".$email."&user=".$username);
		exit();
	}
	else
	{
		$sql = "SELECT username FROM user WHERE username = ?;";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql))
		{
			header("Location: ../signup.php?error=sqlerror");
			exit();	
		}
		else
		{
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$resultCheck = mysqli_stmt_num_rows($stmt);
			if ($resultCheck > 0) {
				header("Location: ../signup.php?error=usernametaken&name=".$name."&age=".$age."&mail=".$email);
				exit();
			}
			else
			{
				$sql = "INSERT INTO user (name, age, gender, email, username, password) VALUES (?, ?, ?, ?, ?, ?);";
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql))
				{
					header("Location: ../signup.php?error=sqlerror");
					exit();	
				}
				else
				{
					$hashedPwd = password_hash($password, PASSWORD_DEFAULT);

					mysqli_stmt_bind_param($stmt, "sissss", $name, $age, $gender, $email, $username, $hashedPwd);
					$result = mysqli_stmt_execute($stmt);
					session_start();
					$_SESSION['username'] = $username;
					header("Location: ../explore.php");
				}
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}

else
{
	header("Location: ../signup.php");
	exit();
}

?>