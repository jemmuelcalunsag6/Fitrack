<?php 
session_start();

$trainer3 = [
    'name' => 'Charles Daplas',
    'specialization' => 'Nutrition Coaching',
    'experience' => '4 years of experience in nutrition coaching and dietary planning.',
    'about' => 'I aim to educate clients on healthy eating habits and lifestyle changes.',
    'testimonial' => '"Coach Charles helped me achieve my nutrition goals!" - Client C'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $trainer3['name']; ?> Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>FitTrack</h1>
        <nav>
            <ul>
                <li><a href="index.php" class="nav-btn">Home</a></li>
                <li><a href="trainer1.php" class="nav-btn">Trainer 1</a></li>
                <li><a href="trainer2.php" class="nav-btn">Trainer 2</a></li>
                <li><a href="trainer3.php" class="nav-btn">Trainer 3</a></li>
                <li><a href="book_session.php" class="nav-btn">Book Session</a></li>
                <li><a href="contact.php" class="nav-btn">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section id="profile">
        <h2><?php echo $trainer3['name']; ?></h2>
        <p>Specialization: <?php echo $trainer3['specialization']; ?></p>
        <p>Experience: <?php echo $trainer3['experience']; ?></p>
        <p>About Me: <?php echo $trainer3['about']; ?></p>
        <h3>Client Testimonials:</h3>
        <blockquote>
            <?php echo $trainer3['testimonial']; ?>
        </blockquote>
    </section>

    <footer>
        <p>&copy; 2024 FitTrack. All rights reserved.</p>
    </footer>
</body>
</html>
