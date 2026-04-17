<?php

$message = '';

$conn = mysqli_connect("localhost", "root", "", "userdb");

if (!$conn) {
	die("Database connection failed");
}

// Create (Insert) User
if (isset($_POST['submit'])) {
	$name = trim($_POST['name']);
	$email = trim($_POST['email']);
	$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

	$stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
	mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $pass);
	mysqli_stmt_execute($stmt);

	if (mysqli_stmt_affected_rows($stmt) > 0) {
		$message = "User created successfully.";
	} else {
		$message = "Error creating user: " . mysqli_error($conn);
	}

	mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
