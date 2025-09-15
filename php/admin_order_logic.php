<?php
session_start();
include('server/connection.php');
include("server/all_orders.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if admin
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['admin'] !== 'da') {
    header('Location: index.php');
    exit();
}

// Delete order
if (isset($_POST['delete_btn_order'])) {
    $order_id = intval($_POST['order_id']);
    $delete_query = "DELETE FROM orders WHERE order_id = $order_id";

    if (mysqli_query($conn, $delete_query)) {
        echo "Uspešno izbrisan order";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    header("Location: adminorder.php");
    exit();
}

// Search by order_id
$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    if ($search !== "") {
        $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
        $stmt->bind_param("i", $search);
        $stmt->execute();
        $stvari = $stmt->get_result();
    }
}
?>