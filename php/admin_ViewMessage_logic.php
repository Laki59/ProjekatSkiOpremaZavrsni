<?php
session_start();
include('server/connection.php');

// Proverava login
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Proverava admina
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['admin'] !== 'da') {
    header('Location: index.php');
    exit();
}

// Uzima message ID
if (!isset($_GET['message_id'])) {
    header('Location: adminMessages.php?error=Nema poruke');
    exit();
}

$message_id = intval($_GET['message_id']);

// Uzima poruke
$stmt = $conn->prepare("SELECT m.*, u.user_name, u.user_email 
                        FROM message m 
                        JOIN users u ON m.user_id = u.user_id
                        WHERE m.message_id = ?");
$stmt->bind_param("i", $message_id);
$stmt->execute();
$message = $stmt->get_result()->fetch_assoc();
?>
