<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $menu_id = $_POST['menu_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    if (empty($user_id) || empty($menu_id) || empty($rating) || empty($comment)) {
        die('Please fill in all fields.');
    }

    $stmt = $mysqli->prepare("INSERT INTO reviews (user_id, menu_id, rating, comment) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die('Prepare failed: ' . $mysqli->error);
    }
    $stmt->bind_param('iiis', $user_id, $menu_id, $rating, $comment);
    if (!$stmt->execute()) {
        die('Execute failed: ' . $stmt->error);
    }
    $stmt->close();

    echo 'Review submitted successfully.';
    exit();
} else {
    die('Invalid request method.');
}
?>
