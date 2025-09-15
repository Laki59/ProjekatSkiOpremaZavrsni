<?php
session_start();
include('server/connection.php');
include("server/all_users.php");

// Ako nije ulogovan korisnik
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Proveri da li je admin
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['admin'] !== 'da') {
    header('Location: index.php');
    exit();
}

// Brisanje korisnika i njegovih porudžbina
if (isset($_POST['delete_btn'])) {
    $delete_user_id = intval($_POST['user_id']);

    $delete_user_query = "DELETE FROM users WHERE user_id = $delete_user_id";
    $delete_orders_query = "DELETE FROM orders WHERE user_id = $delete_user_id";

    // Prvo brišemo porudžbine, zatim korisnika
    mysqli_query($conn, $delete_orders_query);
    mysqli_query($conn, $delete_user_query);

    header("Location: admin.php");
    exit();
}
