<?php
session_start();

$message = '';
$loggedIn = isset($_SESSION['user_id']);

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
	session_unset();
	session_destroy();
	header('Location: session.php');
	exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);

	$conn = mysqli_connect('localhost', 'root', '', 'userdb');
	if (!$conn) {
		die('Database connection failed');
	}

	$stmt = mysqli_prepare($conn, 'SELECT id, name, password FROM users WHERE email = ?');
	mysqli_stmt_bind_param($stmt, 's', $email);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $userId, $userName, $passwordHash);
	if (mysqli_stmt_fetch($stmt) && password_verify($password, $passwordHash)) {
		$_SESSION['user_id'] = $userId;
		$_SESSION['user_name'] = $userName;
		$_SESSION['user_email'] = $email;
		$loggedIn = true;
		$message = 'Login successful.';
	} else {
		$message = 'Invalid email or password.';
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Session Login</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background: #f0f4f8;
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 100vh;
			margin: 0;
		}
		.box {
			width: 390px;
			background: #fff;
			padding: 28px 32px;
			border-radius: 14px;
			box-shadow: 0 18px 40px rgba(0, 0, 0, 0.08);
		}
		h1 {
			margin-top: 0;
			margin-bottom: 20px;
			color: #24292e;
		}
		.message {
			margin-bottom: 18px;
			padding: 12px 14px;
			border-radius: 8px;
			background: #e7f4ff;
			border: 1px solid #c6e4ff;
			color: #1b4f8b;
		}
		label {
			display: block;
			margin-bottom: 8px;
			color: #555;
			font-size: 14px;
		}
		input {
			width: 100%;
			padding: 12px 14px;
			margin-bottom: 18px;
			border: 1px solid #d7dce4;
			border-radius: 8px;
			font-size: 15px;
		}
		button {
			width: 100%;
			padding: 14px 16px;
			border: none;
			border-radius: 10px;
			background: #1a73e8;
			color: white;
			font-size: 16px;
			cursor: pointer;
		}
		button:hover {
			background: #1258b3;
		}
		.info {
			margin: 12px 0;
			background: #f6f8fa;
			padding: 14px 16px;
			border-radius: 10px;
			border: 1px solid #dae1e7;
			color: #333;
		}
		.logout-link {
			display: inline-block;
			margin-top: 14px;
			color: #1976d2;
			text-decoration: none;
		}
	</style>
</head>
<body>
	<div class="box">
		<h1>Session Login</h1>
		<?php if (!empty($message)): ?>
			<div class="message"><?= htmlspecialchars($message) ?></div>
		<?php endif; ?>
		<?php if ($loggedIn): ?>
			<div class="info">
				<strong>Logged in as:</strong><br>
				<?= htmlspecialchars($_SESSION['user_name']) ?> <br>
				<?= htmlspecialchars($_SESSION['user_email']) ?>
			</div>
			<a class="logout-link" href="session.php?action=logout">Logout</a>
		<?php else: ?>
			<form method="post" action="session.php">
				<label for="email">Email</label>
				<input id="email" type="email" name="email" required>
				<label for="password">Password</label>
				<input id="password" type="password" name="password" required>
				<button type="submit" name="login">Login</button>
			</form>
		<?php endif; ?>
	</div>
</body>
</html>
