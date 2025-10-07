<?php
include('db.php');

// Manually include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the required PHPMailer files
require 'C:/xampp/htdocs/fittrack/PHPMailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/fittrack/PHPMailer/src/SMTP.php';
require 'C:/xampp/htdocs/fittrack/PHPMailer/src/Exception.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Generate a unique token and expiration time
    $token = bin2hex(random_bytes(50)); // Generate a random token
    $expiry_time = time() + 3600; // Token expires in 1 hour

    // Store the token and expiry time in the database
    $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
    $stmt->bind_param("sis", $token, $expiry_time, $email);
    $stmt->execute();

    // Send the reset link to the user's email
    $reset_link = "http://localhost/fittrack/reset-password.php?token=" . $token;

    // PHPMailer Configuration
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Set your SMTP server here
    $mail->SMTPAuth = true;
    $mail->Username = 'charlesdaplaz42@gmail.com'; // Your email
    $mail->Password = 'wtqj fnmz cifq hbst'; // Your email password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('noreply@yourdomain.com', 'FitTrack');
    $mail->addAddress($email);
    $mail->Subject = 'Password Reset Request';
    $mail->Body = "Click the following link to reset your password: " . $reset_link;

    // Send the email
    try {
        $mail->send();
        echo "Password reset link sent to your email.";
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Forgot Password</h1>
    <form action="forgot-password.php" method="POST">
        <label for="email">Enter your email:</label>
        <input type="email" name="email" required>
        <button type="submit">Send Reset Link</button>
    </form>
</body>
</html>
