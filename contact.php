<?php     
require 'C:/xampp/htdocs/fittrack/PHPMailer/src/Exception.php';
require 'C:/xampp/htdocs/fittrack/PHPMailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/fittrack/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if (!empty($name) && !empty($email) && !empty($message)) {
        $mail = new PHPMailer(true);
        
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'charlesdaplaz42@gmail.com';
            $mail->Password = 'wtqj fnmz cifq hbst';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($email, $name);
            $mail->addAddress('daplasdapz@gmail.com', 'FitTrack Team');

            $mail->isHTML(false);
            $mail->Subject = 'New Contact Email Submission';
            $mail->Body    = "Name: $name\nEmail: $email\nMessage: $message";

            if ($mail->send()) {
                $confirmation = "Thank you for contacting us!";
            } else {
                $confirmation = "Sorry, there was an error sending your message.";
            }
        } catch (Exception $e) {
            $confirmation = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $confirmation = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <h1>FitTrack</h1>
        <nav>
            <ul>
                <li><a href="index.php" class="nav-btn">Home</a></li>

            </ul>
        </nav>
    </header>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <h2>Contact Us</h2>
        <?php if (isset($confirmation)): ?>
            <p><?php echo $confirmation; ?></p>
        <?php endif; ?>

        <form action="contact.php" method="POST">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="message">Your Message:</label>
            <textarea id="message" name="message" required></textarea><br>

            <button type="submit">Send Message</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 FitTrack. All rights reserved.</p>
    </footer>
</body>
</html>
