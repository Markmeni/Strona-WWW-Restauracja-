<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];
    $message = $_POST['message'];

    $stmt = $mysqli->prepare("INSERT INTO reservations (name, email, phone, date, time, guests, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssssis', $name, $email, $phone, $date, $time, $guests, $message);
    $stmt->execute();
    $stmt->close();

    echo "Reservation successfully made!";
}
?>
