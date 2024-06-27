<?php
include 'db_connection.php';

$result = $mysqli->query("SELECT menu.*, categories.name as category_name FROM menu JOIN categories ON menu.category_id = categories.id");
$menu_items = $result->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($menu_items);
?>
