<?php 
session_start();
include('db.php'); 

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $trainer_id = $_POST['trainer_id'];
    $session_date = $_POST['session_date'];

    // ✅ Removed stray "/" and added a comment
    // Prepare SQL query to insert a new booking
    $query = "INSERT INTO booked_sessions (user_id, trainer_id, session_date, status) 
              VALUES (?, ?, ?, 'pending')";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("iis", $user_id, $trainer_id, $session_date);

        if ($stmt->execute()) {
            // Redirect to dashboard after successful booking
            header("Location: dashboard.php"); 
            exit();
        } else {
            echo "Error: Could not complete your booking. Please try again.";
        }

        $stmt->close();
    } else {
        echo "Error: Could not prepare query.";
    }
}
?>

