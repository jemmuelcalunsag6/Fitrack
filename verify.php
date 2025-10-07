<?php
include('db.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if token exists in the database
    $sql = "SELECT * FROM users WHERE verification_token = '$token' AND verified = 0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Update the user's status to 'verified'
        $update_sql = "UPDATE users SET verified = 1, verification_token = NULL WHERE verification_token = '$token'";
        if ($conn->query($update_sql) === TRUE) {
            echo "Your email has been verified! You can now <a href='login.php'>login</a>.";
        } else {
            echo "Error: Could not verify email.";
        }
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "No token provided.";
}
?>
