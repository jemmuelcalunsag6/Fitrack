<?php  
include('db.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/htdocs/fittrack/PHPMailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/fittrack/PHPMailer/src/SMTP.php';
require 'C:/xampp/htdocs/fittrack/PHPMailer/src/Exception.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form inputs
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    // Hash the password before saving it to the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate a unique verification token
    $verification_token = bin2hex(random_bytes(16)); // Generates a random token

    // Step 1: Check if email exists in the trainers table
    $role = 'user'; // Default role
    $trainer_check = $conn->prepare("SELECT * FROM trainers WHERE email = ?");
    $trainer_check->bind_param("s", $email);
    $trainer_check->execute();
    $trainer_result = $trainer_check->get_result();

    if ($trainer_result->num_rows > 0) {
        $role = 'trainer'; // Set role to trainer if email exists in trainers table
    }
    $trainer_check->close();

    // Step 2: Insert data into the users table, including the role
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, first_name, last_name, verification_token, role) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $username, $email, $hashed_password, $first_name, $last_name, $verification_token, $role);

    if ($stmt->execute()) {
        // Step 3: Send verification email
        $verification_link = "http://localhost/fittrack/verify.php?token=$verification_token";

        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'charlesdaplaz42@gmail.com';
            $mail->Password = 'wtqj fnmz cifq hbst';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('noreply@yourdomain.com', 'FitTrack Team');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification for FitTrack';
            $mail->Body    = "Please verify your email address by clicking on the link below:<br><a href='$verification_link'>$verification_link</a>";

            $mail->send();
            echo "Signup successful! A verification email has been sent to your inbox. Please verify your email to continue.";
        } catch (Exception $e) {
            echo "Error: Unable to send verification email. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Signup</h1>
    </header>

    <section>
        <form action="signup.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required><br>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit">Signup</button>
        </form>

        <!-- Link to login -->
        <div class="login-link">
    <a href="login.php">Already have an account? Login in now!</a>
</div>
    </section>

    <footer>
        <p>&copy; 2024 FitTrack. All rights reserved.</p>
    </footer>
</body>
</html>
