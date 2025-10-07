<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


include('db.php');


$user_id = $_SESSION['user_id'];
$weight = $_POST['weight'];
$height = $_POST['height'];
$body_fat_percentage = $_POST['body_fat_percentage'];
$fitness_level = $_POST['fitness_level'];
$notes = $_POST['notes'];

$date = date('Y-m-d');


$query = "INSERT INTO progress (user_id, date, weight, height, body_fat_percentage, fitness_level, notes) 
          VALUES ('$user_id', '$date', '$weight', '$height', '$body_fat_percentage', '$fitness_level', '$notes')";

if (mysqli_query($conn, $query)) {
  
    header("Location: progress.php?success=1");
} else {
    
    header("Location: progress.php?error=1");
}
?>
