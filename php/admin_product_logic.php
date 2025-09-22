<?php
session_start();
include('server/connection.php');
include("server/all_products.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

//Check admin
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['admin'] !== 'da') {
    header('Location: index.php');
    exit();
}

//Brisi proizvod
if (isset($_POST['delete_btn_order'])) {
    $product_id = intval($_POST['product_id']);
    $delete_query = "DELETE FROM products WHERE product_id = $product_id";

    if (mysqli_query($conn, $delete_query)) {
        echo "Uspešno izbrisan proizvod";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    header("Location: adminProducts.php");
    exit();
}

//Update kolicinu
if (isset($_POST['update_quantity'])) {
    $product_id = intval($_POST['product_id']);
    $new_quantity = intval($_POST['new_quantity']);

    $stmt = $conn->prepare("UPDATE products SET quantity = ? WHERE product_id = ?");
    $stmt->bind_param("ii", $new_quantity, $product_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Količina uspešno ažurirana!";
    } else {
        $_SESSION['message'] = "Greška pri ažuriranju količine!";
    }

    header("Location: adminProducts.php");
    exit();
}

//Trazi po ID-u
$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    if ($search !== "") {
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $search);
        $stmt->execute();
        $all_products = $stmt->get_result();
    }
}
?>