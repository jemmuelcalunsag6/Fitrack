<?php
session_start();
include('db.php');

// Ensure the user is logged in and is a trainer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'trainer') {
    header("Location: login.php"); // Redirect to login if not a trainer
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the booking ID and new status from the form
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];

    // Validate the new status (optional, depending on your requirements)
    $valid_statuses = ['pending', 'completed', 'cancelled'];
    if (!in_array($status, $valid_statuses)) {
        echo "Invalid status.";
        exit();
    }

    // Update the status in the database
    $stmt = $conn->prepare("UPDATE booked_sessions SET status = ? WHERE booking_id = ?");
    $stmt->bind_param("si", $status, $booking_id);
    
    if ($stmt->execute()) {
        // Redirect back to the trainer dashboard with a success message
        header("Location: trainer_dashboard.php?status=success");
    } else {
        // If the query fails, show an error
        echo "Error updating session status.";
    }

    $stmt->close();
}
?>
