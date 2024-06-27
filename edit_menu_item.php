<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $category_id = $_POST['category_id'];

    $stmt = $mysqli->prepare("UPDATE menu SET name = ?, description = ?, price = ?, image = ?, category_id = ? WHERE id = ?");
    $stmt->bind_param('ssdsii', $name, $description, $price, $image, $category_id, $id);
    $stmt->execute();
    $stmt->close();

    header('Location: admin.php');
    exit();
}
?>
