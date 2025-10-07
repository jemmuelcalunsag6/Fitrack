<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db.php');

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM progress WHERE user_id = '$user_id' ORDER BY date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Fitness Progress</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Your Fitness Progress</h1>
        <nav>
            <ul>
            <li><a href="index.php" class="nav-btn">Home</a></li>
                <li><a href="book_session.php" class="nav-btn">Book Session</a></li>
                <li><a href="fitness_tracker.php" class="nav-btn">Fitness Tracker</a></li>
                <li><a href="dashboard.php" class="nav-btn">User Dashboard</a></li>
                <li><a href="contact.php" class="nav-btn">Contact</a></li>
                <li><a href="logout.php" class="nav-btn">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h2>Your Progress:</h2>
        
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<li>";
                    echo "Date: " . date('F j, Y', strtotime($row['date'])) . "<br>";
                    echo "Weight: " . htmlspecialchars($row['weight']) . " kg<br>";
                    echo "Height: " . htmlspecialchars($row['height']) . " cm<br>";
                    echo "Body Fat: " . htmlspecialchars($row['body_fat_percentage']) . "%<br>";
                    echo "Fitness Level: " . htmlspecialchars($row['fitness_level']) . "<br>";
                    echo "Notes: " . htmlspecialchars($row['notes']) . "<br>";
                    echo "</li>";
                }
            } else {
                echo "<li>No progress logs yet.</li>";
            }
            ?>
        
    </section>

    <footer>
        <p>&copy; 2024 FitTrack. All rights reserved.</p></p>
    </footer>
</body>
</html>
