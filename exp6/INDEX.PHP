<?php
 $message = '';
 if (isset($_GET['message'])) {
	 $message = trim($_GET['message']);
 }
 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
	 include 'db.php';
 }
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>User Registration</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background: #eef2f7;
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
			margin: 0;
		}
		.container {
			background: #ffffff;
			padding: 28px 32px;
			border-radius: 12px;
			box-shadow: 0 16px 44px rgba(0, 0, 0, 0.08);
			width: 380px;
		}
		h1 {
			margin-top: 0;
			margin-bottom: 20px;
			font-size: 24px;
			color: #333;
		}
		label {
			display: block;
			margin-bottom: 10px;
			color: #555;
		}
		input {
			width: 100%;
			padding: 12px 14px;
			margin-bottom: 18px;
			border: 1px solid #d4d7dd;
			border-radius: 8px;
			font-size: 15px;
			box-sizing: border-box;
		}
		button {
			width: 100%;
			padding: 14px 16px;
			border: none;
			border-radius: 8px;
			background: #0077ff;
			color: white;
			font-size: 16px;
			cursor: pointer;
		}
		button:hover {
			background: #005fdb;
		}
		.message {
			margin-bottom: 18px;
			padding: 12px 14px;
			border-radius: 8px;
			background: #e8f6ff;
			color: #034b8c;
			border: 1px solid #c6e3ff;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>User Registration</h1>
		<?php if (!empty($message)): ?>
			<div class="message"><?= htmlspecialchars($message) ?></div>
		<?php endif; ?>
		<form method="post" action="">
			<label for="name">Name</label>
			<input id="name" type="text" name="name" required>

			<label for="email">Email</label>
			<input id="email" type="email" name="email" required>

			<label for="password">Password</label>
			<input id="password" type="password" name="password" required>

			<button type="submit" name="submit">Create User</button>
		</form>
	</div>
</body>
</html>
