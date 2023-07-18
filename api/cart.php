<?php
session_start();
include('../includes/config/database.php');

$user = $_SESSION['user'];
$userId = $user['id'];
$query = "SELECT * FROM cart WHERE userId = '$userId'";
$result = mysqli_query($db, $query);
$cart = [];
while($row = mysqli_fetch_assoc($result)) {
	$cart[] = $row;
}

echo json_encode(['user' => $user, 'cart' => $cart]);