<?php 
session_start();
include 'db_connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Grill Restaurant</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php
require_once("./nav.php");
?>
    <main>
        <section>
            <div  id="contact">
                <div class="contact-info">
                    <h2>Contact Us</h2>
                    <h3>Address</h3>
                    <p>123 Grill Street,<br>
                    Cityville, ST 12345</p>
                    <h3>Phone</h3>
                    <p>(123) 456-7890</p>
                    <h3>Email</h3>
                    <p><a href="mailto:info@grillrestaurant.com">info@grillrestaurant.com</a></p>
                </div>
            </div>
            <h3>Opening Hours</h3>
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
