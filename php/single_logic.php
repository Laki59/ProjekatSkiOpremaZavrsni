<?php
session_start();
include(__DIR__ . '/../server/connection.php');

// Jezik iz cookie-a ili default
$lang = "rs";
if (isset($_GET['lang'])) {
  $lang = $_GET['lang'];
  setcookie("lang", $lang, time() + (86400 * 30), "/");
} elseif (isset($_COOKIE['lang'])) {
  $lang = $_COOKIE['lang'];
}

if (isset($_SESSION['logged_in'])) {
  if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $stmt = $conn->prepare("
      SELECT p.*, 
             COALESCE(t.name, p.product_name) AS trans_name,
             COALESCE(t.description, p.product_description) AS trans_description,
             p.product_category AS trans_category
      FROM products p
      LEFT JOIN product_translations t 
        ON p.product_id = t.product_id AND t.lang = ?
      WHERE p.product_id = ?
    ");

    if (!$stmt) {
      die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("si", $lang, $product_id);
    $stmt->execute();
    $product = $stmt->get_result();

  } else {
            header('Location: ../index.php');
    exit;
  }
} else {
            header('Location: ../login.php?error=You must login');
  exit;
}
?>