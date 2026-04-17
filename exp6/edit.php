<?php
// Update user record by ID
$message = '';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
	die('Invalid user ID.');
}

$conn = mysqli_connect('localhost', 'root', '', 'userdb');
if (!$conn) {
	die('Database connection failed');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
	$name = trim($_POST['name']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);

	if ($password !== '') {
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		$stmt = mysqli_prepare($conn, 'UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?');
		mysqli_stmt_bind_param($stmt, 'sssi', $name, $email, $hashedPassword, $id);
	} else {
		$stmt = mysqli_prepare($conn, 'UPDATE users SET name = ?, email = ? WHERE id = ?');
		mysqli_stmt_bind_param($stmt, 'ssi', $name, $email, $id);
	}

	if ($stmt && mysqli_stmt_execute($stmt)) {
		$message = 'User updated successfully.';
	} else {
		$message = 'Error updating user: ' . mysqli_error($conn);
	}
	if ($stmt) {
		mysqli_stmt_close($stmt);
	}
}

$stmt = mysqli_prepare($conn, 'SELECT name, email FROM users WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $nameValue, $emailValue);
if (!mysqli_stmt_fetch($stmt)) {
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	die('User not found.');
}
mysqli_stmt_close($stmt);

mysqli_close($conn);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit User</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background: #f4f6fb;
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
			margin: 0;
		}
		.card {
			width: 420px;
			background: #fff;
			padding: 30px;
			border-radius: 14px;
			box-shadow: 0 18px 40px rgba(0, 0, 0, 0.1);
		}
		h1 {
			margin-top: 0;
			margin-bottom: 22px;
			color: #222;
		}
		label {
			display: block;
			margin-bottom: 8px;
			color: #4d4d4d;
			font-size: 14px;
		}
		input {
			width: 100%;
			padding: 12px 14px;
			margin-bottom: 18px;
			border: 1px solid #d9dbe5;
			border-radius: 8px;
			font-size: 15px;
		}
		button {
			width: 100%;
			padding: 14px 16px;
			border: none;
			border-radius: 10px;
			background: #1976d2;
			color: #fff;
			font-size: 16px;
			cursor: pointer;
		}
		button:hover {
			background: #135cb0;
		}
		.message {
			margin-bottom: 18px;
			padding: 12px 14px;
			border-radius: 8px;
			background: #e8f0ff;
			color: #1f3d73;
			border: 1px solid #c7d7ff;
		}
		.note {
			font-size: 13px;
			color: #666;
			margin-top: -12px;
			margin-bottom: 18px;
		}
	</style>
</head>
<body>
	<div class="card">
		<h1>Edit User</h1>
		<?php if (!empty($message)): ?>
			<div class="message"><?= htmlspecialchars($message) ?></div>
		<?php endif; ?>
		<form method="post" action="?id=<?= htmlspecialchars($id) ?>">
			<label for="name">Name</label>
			<input id="name" type="text" name="name" value="<?= htmlspecialchars($nameValue) ?>" required>

			<label for="email">Email</label>
			<input id="email" type="email" name="email" value="<?= htmlspecialchars($emailValue) ?>" required>

			<label for="password">New Password</label>
			<input id="password" type="password" name="password" placeholder="Leave blank to keep current password">
			<div class="note">Only enter a password if you want to update it.</div>

			<button type="submit" name="update">Save Changes</button>
		</form>
	</div>
</body>
</html>
