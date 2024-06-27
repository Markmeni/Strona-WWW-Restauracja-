<?php 
session_start();
include 'db_connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation - Grill Restaurant</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php
require_once("./nav.php");
?>
    <main>
        <section>
            <h2>Reservation</h2>
            <form id="reservation-form" action="make_reservation.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" required>
                
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
                
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>
                
                <label for="guests">Number of Guests:</label>
                <input type="number" id="guests" name="guests" required>
                
                <label for="message">Special Requests:</label>
                <textarea id="message" name="message"></textarea>
                
                <button type="submit">Submit Reservation</button>
            </form>
            <p id="response-message" style="display:none;"></p>
        </section>
    </main>
    <footer>
        &copy; 2023 Grill Restaurant
    </footer>
    <script src="js/main.js"></script>
</body>
</html>
