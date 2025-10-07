<?php     
session_start();
include('db.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to fetch user by email
    $stmt = $conn->prepare("SELECT id, password, role, verified FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Check if the email is verified
        if ($user['verified'] == 0) {
            echo "<script>alert('Your account is not verified. Please check your email for the verification link.');</script>";
        } else {
            // Check if password matches
            if (password_verify($password, $user['password'])) { 
                $_SESSION['user_id'] = $user['id'];  // Store user ID in session
                $_SESSION['role'] = $user['role'];  // Store user role in session

                if ($user['role'] === 'trainer') {
                    // Fetch trainer_id if role is 'trainer'
                    $trainer_id_query = "SELECT trainer_id FROM trainers WHERE email = ?";
                    $stmt_trainer = $conn->prepare($trainer_id_query);
                    $stmt_trainer->bind_param("s", $email);
                    $stmt_trainer->execute();
                    $trainer_result = $stmt_trainer->get_result();

                    if ($trainer_result->num_rows > 0) {
                        $trainer_data = $trainer_result->fetch_assoc();
                        $_SESSION['trainer_id'] = $trainer_data['trainer_id']; // Set trainer ID
                    }

                    header("Location: trainer_dashboard.php");  // Redirect trainers
                    exit();
                } else {
                    // Redirect regular users to their dashboard
                    header("Location: dashboard.php");
                    exit();
                }
            } else {
                echo "<script>alert('Invalid credentials!');</script>";
            }
        }
    } else {
        echo "<script>alert('Invalid credentials!');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>

    <section>
        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit">Login</button>
        </form>

        <div>
            <a href="forgot-password.php" class="gold-link">Forgot Password?</a>
            <span> | </span>
            <a href="signup.php" class="gold-link">Sign Up Now!</a>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 FitTrack. All rights reserved.</p>
    </footer>
</body>
</html>
