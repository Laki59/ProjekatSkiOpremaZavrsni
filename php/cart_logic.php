<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit();
}

if (isset($_POST['addcart_btn'])) {
    include('server/connection.php');

    $product_id = $_POST['product_id'];
    $new_type = $_POST['product_type']; 

    //Provera dostupnosti proizvoda
    $stmt = $conn->prepare("SELECT quantity FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($available_quantity);
    $stmt->fetch();
    $stmt->close();

    if ($available_quantity <= 0) {
        echo "<script>alert('Ovaj proizvod trenutno nije dostupan.'); window.location.href = 'shop.php';</script>";
        exit();
    }
    

    //Provera da li u korpi već postoji drugačiji tip proizvoda
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $existing_types = array_unique(array_column($_SESSION['cart'], 'product_type'));
        if (count($existing_types) > 0 && $existing_types[0] !== $new_type) {
            echo "<script>alert('Ne možete mešati proizvode za kupovinu i iznajmljivanje u istoj korpi!'); window.location.href = 'shop.php';</script>";
            exit();
        }
    }
    //Kreira proizvod koji ide u korpu
    $product_lista = array(
        'product_id' => $product_id,
        'product_name' => $_POST['product_name'],
        'product_price' => $_POST['product_price'],
        'product_image' => $_POST['product_image'],
        'product_quantity' => 1,
        'product_type' => $new_type,
        'start_date' => $_POST['start_date'] ?? '',
        'end_date' => $_POST['end_date'] ?? ''
    );

    //Proverava da li kolica postoje, ako da, da li je ta stvar vec u kolicima
if (isset($_SESSION['cart'])) {
    $product_lista_id = array_column($_SESSION['cart'], "product_id");
    if (!in_array($product_id, $product_lista_id)) {
        $_SESSION['cart'][$product_id] = $product_lista;
    } else {
        echo "<script>alert('Već je u korpi');</script>";
    }
    } else {
        //Pravi korpu ako korpa ne postoji
        $_SESSION['cart'][$product_id] = $product_lista;

    }

    TotalCart();
}


else if (isset($_POST['remove_btn'])) {
    include('server/connection.php'); 

    $product_id = $_POST['product_id'];

    
    if (isset($_SESSION['cart'][$product_id])) {
        $removed_qty = $_SESSION['cart'][$product_id]['product_quantity'];
        unset($_SESSION['cart'][$product_id]);
    }

    TotalCart();
    header('location: cart.php');
    exit();
}


function calculateDays($start, $end) {
    $startDate = new DateTime($start);
    $endDate = new DateTime($end);
    $interval = $startDate->diff($endDate);
    return max(1, $interval->days); // makar 1 dan
}

function TotalCart() {
    $total = 0;
    foreach ($_SESSION['cart'] as $product) {
        $price = $product['product_price'];
        $quantity = $product['product_quantity'];
        $type = $product['product_type'];

        if ($type == 'rent') {
            $days = calculateDays($product['start_date'], $product['end_date']);
            $total += ($price * 0.1 * $days) * $quantity;
        } else {
            $total += $price * $quantity;
        }
    }
    $_SESSION['total'] = $total;
}
?>