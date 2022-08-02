<?php

if(isset($_POST['login']))
{
	require 'db_conn.php';

	$username = $_POST['user'];
	$password = $_POST['pwd'];

	if(empty($username) || empty($password))
	{
		header("Location: ../login.php?error=emptyfields");
		exit();
	}
	else
	{
		$sql = "SELECT * FROM user WHERE username = ?;";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql))
		{
			header("Location: ../login.php?error=sqlerror");
			exit();	
		}
		else
		{
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			if($row = mysqli_fetch_assoc($result)) 
			{
				// if($password === $row['password'])
				if(password_verify($password, $row['password']))
				{
					session_start();
					$_SESSION['username'] = $row['username'];
					header("Location: ../explore.php");
				}
				else
				{
					header("Location: ../login.php?error=nouser");
				}
			}
			else
			{
				header("Location: ../login.php?error=nouser");
			}
		}
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}
}
else
{
	header("Location: ../login.php");
	exit();
}
?>