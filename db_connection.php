<?php
$mysqli = new mysqli('localhost', 'root', '', 'grill_restaurant');
if ($mysqli->connect_error) {
    die('Connect Error: ' . $mysqli->connect_error);
}
?>
