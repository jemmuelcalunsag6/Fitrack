<?php    
session_start();
include('db.php');

// Fetch trainer data
$trainer_query = "SELECT * FROM trainers";
$trainer_result = mysqli_query($conn, $trainer_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - FitTrack</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Automatically play the song -->
    <audio autoplay loop>
        <source src="song.mp3" type="audio/mp3">
        Your browser does not support the audio element.
    </audio>

    <header>
        <h1>Welcome to FitTrack</h1>
        <nav>
            <ul>
                <li><a href="#home-section" class="nav-btn">Home</a></li>
                <li><a href="#trainers-section" class="nav-btn">Trainers</a></li>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li><a href="login.php" class="nav-btn">Login</a></li>
                <?php else: ?>
                    <li><a href="dashboard.php" class="nav-btn">Dashboard</a></li>
                    <li><a href="contact.php" class="nav-btn">Contact</a></li> 
                    <li><a href="logout.php" class="nav-btn">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home-section" class="hero-section">
        <h2>Your Fitness Journey Continues Here!</h2>
        <p>Track your progress in order  to have the first step in achieving your fitness goals.</p>
    </section>

    <!-- Trainers Section -->
    <section id="trainers-section" class="trainers-section">
        <h2>Meet Our Trainers</h2>
        <div class="trainers">
            <?php
            if (mysqli_num_rows($trainer_result) > 0) {
                while ($trainer = mysqli_fetch_assoc($trainer_result)) {
                    echo "<div class='trainer-card'>";

                    // Determine image path
                    $image_path = 'images/default.jpg'; 
                    if ($trainer['first_name'] === "Viel") {
                        $image_path = 'images/viel.jpg';
                    } elseif ($trainer['first_name'] === "Dhann") {
                        $image_path = 'images/dhann.jpg';
                    } elseif ($trainer['first_name'] === "Charles") {
                        $image_path = 'images/charles.jpg';
                    }

                    // Fallback if file does not exist
                    if (!file_exists($image_path)) {
                        $image_path = 'images/default.jpg'; 
                    }

                    echo "<img src='" . htmlspecialchars($image_path) . "' alt='" . htmlspecialchars($trainer['first_name']) . " " . htmlspecialchars($trainer['last_name']) . "'>";
                    echo "<h3>" . htmlspecialchars($trainer['first_name']) . " " . htmlspecialchars($trainer['last_name']) . "</h3>";
                    echo "<p><strong>Specialization:</strong> " . htmlspecialchars($trainer['specialization']) . "</p>";
                    echo "<p><strong>Experience:</strong> " . htmlspecialchars($trainer['experience']) . " years</p>";
                    echo "<p><strong>About:</strong> " . htmlspecialchars($trainer['about_me']) . "</p>";
                    echo "<a class='book-btn' href='book_session.php?trainer_id=" . htmlspecialchars($trainer['trainer_id']) . "'>Book a Session</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>No trainers available.</p>";
            }
            ?>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 FitTrack. All rights reserved.</p>
    </footer>

    <!-- External JavaScript files -->
    <script src="js/trainer-interactions.js"></script>
</body>
</html>
