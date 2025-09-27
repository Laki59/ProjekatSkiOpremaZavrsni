<?php
session_start();

if (!empty($_SESSION['cart']) && isset($_POST['checkout'])) {
    //nastavi
} else {
    header('location: cart.php?error=Your cart is empty');
    exit();
}

?>