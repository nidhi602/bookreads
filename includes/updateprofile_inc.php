<?php

session_start();

if(isset($_POST['update']))
{
	require 'db_conn.php';

	$name = $_POST['name'];
	$age = $_POST['age'];
    $gender = $_POST['gender'];
	$email = $_POST['mail'];
	// $new_username = $_POST['user'];
    $username = $_SESSION['username'];

	if(empty($name) || empty($age) || empty($email) || empty($username) || empty($password))
	{
		header("Location: ../updateprofile.php?error=emptyfields&name=".$name."&age=".$age."&mail=".$email."&user=".$username);
		exit();
	}
	if(!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $name))
	{
		header("Location: ../updateprofile.php?error=invalidname");
		exit();

	}
    else if($age <= 0)
    {
        header("Location: ../updateprofile.php?error=invalidage");
		exit();   
    }
	else if(!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+(\.[a-zA-Z]{2,5})+$/",$email))
	{
		header("Location: ../updateprofile.php?error=invalidmail");
		exit();
	}
	else
	{
		$sql = "UPDATE user SET name = ?, age = ?, gender = ?, email = ? WHERE username = ?;";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql))
		{
			header("Location: ../updateprofile.php?error=sqlerror");
		}
		else
		{
			mysqli_stmt_bind_param($stmt, "sisss", $name, $age, $gender, $email, $username);
			$result = mysqli_stmt_execute($stmt);
			// if($result)
			// 	echo "Updated!";
			// else
			// 	echo "<br>Error: ".$sql."<br>".mysqli_error($conn);
			header("Location: ../updateprofile.php?result=success");
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else
{
	header("Location: ../updateprofile.php");
	exit();
}

?>