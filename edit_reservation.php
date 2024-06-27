<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];

    $stmt = $mysqli->prepare("UPDATE reservations SET name = ?, email = ?, phone = ?, date = ?, time = ?, guests = ? WHERE id = ?");
    $stmt->bind_param('ssssssi', $name, $email, $phone, $date, $time, $guests, $reservation_id);
    $stmt->execute();
    $stmt->close();

    header('Location: admin.php');
    exit();
}
?>
