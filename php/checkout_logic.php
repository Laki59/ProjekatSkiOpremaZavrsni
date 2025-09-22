<?php
session_start();

if (!empty($_SESSION['cart']) && isset($_POST['checkout'])) {
    //nastavi
} else {
    header('location: cart.php?error=Your cart is empty');
    exit();
}

//Provera da li je u korpi neka renta stvar
$hasRental = false;
foreach ($_SESSION['cart'] as $item) {
    if (isset($item['item_type']) && $item['item_type'] == 'rent') {
        $hasRental = true;
        break;
    }
}
?>