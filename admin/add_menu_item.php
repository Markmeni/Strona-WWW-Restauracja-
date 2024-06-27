<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $category_id = $_POST['category_id'];

    $stmt = $mysqli->prepare("INSERT INTO menu (name, description, price, image, category_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('ssdsi', $name, $description, $price, $image, $category_id);
    $stmt->execute();
    $stmt->close();

    echo "Menu item added successfully!";
}
?>
