<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grill Restaurant</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php
require_once("./nav.php");
?>
    <main>
        <section class="welcome-section">
            <h2>Welcome to Our Grill Restaurant</h2>
            <p>Enjoy the best grilled dishes in town! Our restaurant offers a cozy and inviting atmosphere where you can savor mouth-watering meals prepared with the freshest ingredients. Whether you're here for a family dinner, a romantic evening, or a casual meal with friends, we promise an unforgettable dining experience.</p>
        </section>
        <section class="hours-section">
            <h2>Opening Hours</h2>
            <ul class="hours-list">
                <li>Monday: 11:00 AM - 10:00 PM</li>
                <li>Tuesday: 11:00 AM - 10:00 PM</li>
                <li>Wednesday: 11:00 AM - 10:00 PM</li>
                <li>Thursday: 11:00 AM - 10:00 PM</li>
                <li>Friday: 11:00 AM - 11:00 PM</li>
                <li>Saturday: 11:00 AM - 11:00 PM</li>
                <li>Sunday: 12:00 PM - 9:00 PM</li>
            </ul>
        </section>
    </main>
    <footer>
        &copy; 2023 Grill Restaurant
    </footer>
    <script src="js/main.js"></script>
</body>
</html>
