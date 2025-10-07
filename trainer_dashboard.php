<?php
session_start();
include('db.php');

// Ensure user is logged in and is a trainer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'trainer') {
    echo "You are not authorized to view the trainer dashboard.";
    exit();
}

$trainer_id = $_SESSION['trainer_id'];  // Fetch the trainer's ID from the session

// Fetch the trainer's name
$stmt_name = $conn->prepare("SELECT first_name, last_name FROM trainers WHERE trainer_id = ?");
$stmt_name->bind_param("i", $trainer_id);
$stmt_name->execute();
$result_name = $stmt_name->get_result();

if ($result_name->num_rows > 0) {
    $trainer = $result_name->fetch_assoc();
    $trainer_name = htmlspecialchars($trainer['first_name'] . ' ' . $trainer['last_name']);
} else {
    $trainer_name = "Trainer";
}

$stmt_name->close();

// Fetch all booked sessions for the trainer
$stmt = $conn->prepare("SELECT b.booking_id, b.session_date, b.status, u.first_name, u.last_name
                        FROM booked_sessions b
                        JOIN users u ON b.user_id = u.id
                        WHERE b.trainer_id = ?");
$stmt->bind_param("i", $trainer_id); 
$stmt->execute();
$result = $stmt->get_result();

// Check for success message in URL
$status_message = '';
if (isset($_GET['status']) && $_GET['status'] == 'success') {
    $status_message = "Session status updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Dashboard - FitTrack</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<audio autoplay loop>
        <source src="gymsong.mp3" type="audio/mp3">
        Your browser does not support the audio element.
    </audio>
    <header>
        <h1>Welcome to Your Trainer Dashboard, <?php echo $trainer_name; ?>!</h1>
        <nav>
            <ul>
                <li><a href="logout.php" class="nav-btn">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section id="home-section" class="hero-section">
        <h2>Your Fitness Journey Continues Here</h2>
        <p>Manage your booked sessions and interact with your clients.</p>
    </section>

    <!-- Success Message Section -->
    <?php if ($status_message): ?>
        <div class="status-message">
            <p><?php echo htmlspecialchars($status_message); ?></p>
        </div>
    <?php endif; ?>

    <section id="sessions-section" class="sessions-section">
        <h2>Booked Sessions</h2>
        <div class="sessions">
            <table border="1">
                <tr>
                    <th>Booking ID</th>
                    <th>Session Date</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['booking_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['session_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td>
                            <form action="update_session_status.php" method="POST">
                                <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                <select name="status">
                                    <option value="pending" <?php echo $row['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="completed" <?php echo $row['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                    <option value="cancelled" <?php echo $row['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 FitTrack. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
$stmt->close();
?>
