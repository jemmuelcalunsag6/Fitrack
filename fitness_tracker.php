<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


include('db.php');

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Tracker</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Track Your Fitness Progress</h1>
        <nav>
            <ul>
            <li><a href="index.php" class="nav-btn">Home</a></li>
                <li><a href="book_session.php" class="nav-btn">Book Session</a></li>
                <li><a href="progress.php" class="nav-btn">Progress</a></li>
                <li><a href="dashboard.php" class="nav-btn">User Dashboard</a></li>
                <li><a href="contact.php" class="nav-btn">Contact</a></li>
                <li><a href="logout.php" class="nav-btn">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h2>Log Your Fitness Progress</h2>
        <form action="save_progress.php" method="POST">
            <label for="weight">Weight (kg):</label>
            <input type="number" step="0.01" name="weight" required><br>

            <label for="height">Height (cm):</label>
            <input type="number" name="height" required><br>

            <label for="body_fat_percentage">Body Fat Percentage (%):</label>
            <input type="number" step="0.01" name="body_fat_percentage" required><br>

            <label for="fitness_level">Fitness Level:</label>
            <select name="fitness_level" required>
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Advanced">Advanced</option>
            </select><br>

            <label for="notes">Notes:</label>
            <textarea name="notes"></textarea><br>

            <button type="submit">Save Progress</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 FitTrack. All rights reserved.</p>
    </footer>
</body>
</html>
