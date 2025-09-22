<?php
session_start();
include(__DIR__ . '/../server/connection.php');

if (isset($_POST['place_order_btn'])) {
    $name = $_POST['ime'];
    $email = $_POST['email'];
    $phone = $_POST['broj'];
    $city = $_POST['grad'];
    $address = $_POST['adresa'];
    $order_cost = $_SESSION['total'];
    $user_id = $_SESSION['user_id'];
    $order_date = date('Y-m-d H:i:s');

    //Provera da li je renta ili kupovina
    $order_status = "Pouzecem"; 
    foreach ($_SESSION['cart'] as $item) {
        if (isset($item['product_type']) && $item['product_type'] === 'rent') {
            $order_status = "Renta";
            break;
        }
    }

    //Insert order u orders tabelu
    $stmt = $conn->prepare("INSERT INTO orders(order_cost, order_status, user_id, user_phone, user_city, user_address, order_date) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isiisss', $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date);
    $stmt->execute();

    $order_id = $stmt->insert_id;

    //Insert iteme u order_items
    foreach ($_SESSION['cart'] as $key => $product) {
        $product_id = $product['product_id'];
        $product_name = $product['product_name'];
        $product_image = $product['product_image'];
        $product_price = $product['product_price'];
        $product_quantity = $product['product_quantity'];

        $product_type = isset($product['product_type']) ? $product['product_type'] : 'buy';
        $start_date = ($product_type === 'rent' && isset($product['start_date'])) ? $product['start_date'] : null;
        $end_date = ($product_type === 'rent' && isset($product['end_date'])) ? $product['end_date'] : null;

        $stmt1 = $conn->prepare("INSERT INTO order_items 
            (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date, start_date, end_date, rent_type) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt1->bind_param(
            'iissiiissss',
            $order_id,
            $product_id,
            $product_name,
            $product_image,
            $product_price,
            $product_quantity,
            $user_id,
            $order_date,
            $start_date,
            $end_date,
            $product_type
        );
        $stmt1->execute();

        //Smanji stock u products tabeli samo sada 
        if ($product_type === 'buy') {
            $stmt2 = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE product_id = ?");
            $stmt2->bind_param("ii", $product_quantity, $product_id);
            $stmt2->execute();
        }
    }

    //Isprazni korpu i preusmeri korisnika
    unset($_SESSION['cart']);
    header('Location: ../account.php?message=Narudžbina uspešno kreirana');
    exit();
}
?>
