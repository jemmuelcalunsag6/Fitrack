<?php  
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db.php');

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<!-- Background Music -->
<audio autoplay loop>
        <source src="chillsong.mp3" type="audio/mp3">
        Your browser does not support the audio element.
    </audio>
<body>
    <header>
        <h1>Welcome to FitTrack, <?php echo htmlspecialchars($user['first_name']); ?>!</h1>
        <nav>
            <ul>
                <li><a href="user_home.php" class="nav-btn">Home</a></li>
                <li><a href="book_session.php" class="nav-btn">Book Session</a></li>
                <li><a href="fitness_tracker.php" class="nav-btn">Fitness Tracker</a></li>
                <li><a href="progress.php" class="nav-btn">Progress</a></li>
                <li><a href="contact.php" class="nav-btn">Contact</a></li>
                <li><a href="logout.php" class="nav-btn">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section id="dashboard">
        <h2>Your Profile</h2>
        <p>Name: <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        <p>Member since: <?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>

        <h3>Your Booked Sessions:</h3>
        
        <?php
        // Fetch booked sessions with trainer names and status
        $booking_query = "SELECT bs.session_date, bs.status, t.first_name, t.last_name
            FROM booked_sessions AS bs
            JOIN trainers AS t ON bs.trainer_id = t.trainer_id
            WHERE bs.user_id = '$user_id'";
        
        $booking_result = mysqli_query($conn, $booking_query);

        if (mysqli_num_rows($booking_result) > 0) {
            echo "<ul>";
            while ($booking = mysqli_fetch_assoc($booking_result)) {
                $trainer_name = htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']);
                $status = htmlspecialchars(ucfirst($booking['status'])); // Capitalize status
                echo "<li>
                    Session with Trainer: $trainer_name on " . date('F j, Y', strtotime($booking['session_date'])) . "<br>
                    Status: <strong>$status</strong>
                </li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No bookings yet.</p>";
        }
        ?>

        <h3>Your Progress:</h3>
        
        <?php
        $progress_query = "SELECT * FROM progress WHERE user_id = '$user_id' ORDER BY date DESC";
        $progress_result = mysqli_query($conn, $progress_query);

        if (mysqli_num_rows($progress_result) > 0) {
            echo "<ul>";
            while ($progress = mysqli_fetch_assoc($progress_result)) {
                echo "<li>";
                echo "Date: " . date('F j, Y', strtotime($progress['date'])) . "<br>";
                echo "Weight: " . htmlspecialchars($progress['weight']) . " kg<br>";
                echo "Height: " . htmlspecialchars($progress['height']) . " cm<br>";
                echo "Body Fat: " . htmlspecialchars($progress['body_fat_percentage']) . "%<br>";
                echo "Fitness Level: " . htmlspecialchars($progress['fitness_level']) . "<br>";
                echo "Notes: " . htmlspecialchars($progress['notes']) . "<br>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No progress logs yet.</p>";
        }
        ?>
        
    </section>

    <footer>
        <p>&copy; FitTrack | All rights reserved.</p>
    </footer>
</body>
</html>
