<?php 
session_start();
include('db.php'); // Database connection

if (!isset($_SESSION['user_id'])) {
    die("Error: You must log-in in order to book a session.");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trainer_id = $_POST['trainer_id'];
    $session_date = $_POST['session_date'];
    
    if (!empty($trainer_id) && !empty($session_date)) {
        // Check if user_id exists in the users table
        $user_check_query = "SELECT id FROM users WHERE id = ?";
        $stmt = $conn->prepare($user_check_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            die("Error: You must log-in in order to book a session.");
        }

        // Insert booking
        $insert_query = "INSERT INTO booked_sessions (user_id, trainer_id, session_date, status) VALUES (?, ?, ?, 'pending')";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("iis", $user_id, $trainer_id, $session_date);

        if ($stmt->execute()) {
            $message = "Session successfully booked!";
        } else {
            $message = "Error: " . $stmt->error;
        }
    } else {
        $message = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Session</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>FitTrack</h1>
        <nav>
            <ul>
                <li><a href="index.php" class="nav-btn">Home</a></li>
                <li><a href="trainer1.php" class="nav-btn">Trainer 1</a></li>
                <li><a href="trainer2.php" class="nav-btn">Trainer 2</a></li>
                <li><a href="trainer3.php" class="nav-btn">Trainer 3</a></li>
                <li><a href="contact.php" class="nav-btn">Contact</a></li>
            </ul>
        </nav>
    </header>

    <h2>Book a Session</h2>
    <form action="book_session.php" method="POST">
    <div class="form-group">
        <label for="trainer_id">Select Trainer:</label>
        <select name="trainer_id" id="trainer_id" required>
            <option value="1">Viel Dela Cruz</option>
            <option value="2">Dhann Dalistan</option>
            <option value="3">Charles Daplas</option>
        </select>
    </div>

    <div class="form-group session-date">
        <label for="session_date">Session Date:</label>
        <input type="datetime-local" name="session_date" id="session_date" required>
    </div>

    <button type="submit">Book Session</button>
</form>

    <?php if (isset($message)) echo "<p>$message</p>"; ?>

    <footer>
        <p>&copy; 2024 FitTrack. All rights reserved.</p>
    </footer>
</body>
</html>
