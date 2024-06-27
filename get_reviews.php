<?php
include 'db_connection.php';

$menu_id = $_GET['menu_id'];

$query = "SELECT reviews.*, users.username FROM reviews JOIN users ON reviews.user_id = users.id WHERE menu_id = $menu_id";
$result = $mysqli->query($query);

$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

echo json_encode(['reviews' => $reviews]);
?>
