<?php
session_start();
include('server/connection.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

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

if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);

    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
} else {
    header('Location: adminProducts.php');
    exit();
}

if (isset($_POST['update_product'])) {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $product_color = $_POST['product_color'];

    $product_image = $product['product_image'];
    if (!empty($_FILES['product_image']['name'])) {
        $product_image = basename($_FILES['product_image']['name']);
        move_uploaded_file($_FILES['product_image']['tmp_name'], $product_image);
    }

    $product_image2 = $product['product_image2'];
    if (!empty($_FILES['product_image2']['name'])) {
        $product_image2 = basename($_FILES['product_image2']['name']);
        move_uploaded_file($_FILES['product_image2']['tmp_name'], $product_image2);
    }

    $product_image3 = $product['product_image3'];
    if (!empty($_FILES['product_image3']['name'])) {
        $product_image3 = basename($_FILES['product_image3']['name']);
        move_uploaded_file($_FILES['product_image3']['tmp_name'], $product_image3);
    }

    $product_image4 = $product['product_image4'];
    if (!empty($_FILES['product_image4']['name'])) {
        $product_image4 = basename($_FILES['product_image4']['name']);
        move_uploaded_file($_FILES['product_image4']['tmp_name'], $product_image4);
    }

    $stmt = $conn->prepare("UPDATE products SET product_name=?, product_description=?, product_price=?, product_color=?, product_image=?, product_image2=?, product_image3=?, product_image4=? WHERE product_id=?");
    $stmt->bind_param("ssdsssssi", $product_name, $product_description, $product_price, $product_color, $product_image, $product_image2, $product_image3, $product_image4, $product_id);

    if ($stmt->execute()) {
        header('Location: adminProducts.php');
        exit();
    } else {
        echo "Error updating product: " . $conn->error;
    }
}
?>