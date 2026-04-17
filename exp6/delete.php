<?php
// Delete a user record by ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
	die('Invalid user ID.');
}

$conn = mysqli_connect('localhost', 'root', '', 'userdb');
if (!$conn) {
	die('Database connection failed');
}

$stmt = mysqli_prepare($conn, 'DELETE FROM users WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
	$message = 'User deleted successfully.';
} else {
	$message = 'No user found with the provided ID.';
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

header('Location: INDEX.PHP?message=' . urlencode($message));
exit;
?>
