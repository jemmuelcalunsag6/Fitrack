<?php 
include('db.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validate the token and check if it's expired
    $current_time = time();
    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expiry > ?");
    $stmt->bind_param("si", $token, $current_time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_password = $_POST['password'];
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the user's password in the database
            $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?");
            $stmt->bind_param("ss", $hashed_password, $token);
            $stmt->execute();

            header("Location: login.php");
            exit();

        }
    } else {
        echo "Invalid or expired token.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Reset Your Password</h1>
    <form action="reset-password.php?token=<?php echo htmlspecialchars($_GET['token']); ?>" method="POST">
        <label for="password">Enter New Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
