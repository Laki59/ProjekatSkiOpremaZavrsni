<?php
session_start();
include('server/connection.php');

// Autorizacija samo za admina
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

$upload_dir = 'assets/imgs/proizvod/';  // direktorijum za slike

//Dodavanje proizvoda
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $product_color = $_POST['product_color'];
    $product_category = $_POST['product_category'];

    //Engleski prevod (ako admin unese)
    $product_name_en = isset($_POST['product_name_en']) ? $_POST['product_name_en'] : null;
    $product_description_en = isset($_POST['product_description_en']) ? $_POST['product_description_en'] : null;

    $product_image = uploadImage('product_image');
    $product_image2 = uploadImage('product_image2');
    $product_image3 = uploadImage('product_image3');
    $product_image4 = uploadImage('product_image4');

    //Insert u products
    $stmt = $conn->prepare("INSERT INTO products 
        (product_name, product_description, product_price, product_color, product_category, product_image, product_image2, product_image3, product_image4) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("ssissssss", 
        $product_name, $product_description, $product_price, $product_color, $product_category, 
        $product_image, $product_image2, $product_image3, $product_image4
    );

    if ($stmt->execute()) {
        $product_id = $stmt->insert_id;

        //Upis u product_translations za SR (default)
        $stmtT = $conn->prepare("INSERT INTO product_translations (product_id, lang, name, description) VALUES (?, 'rs', ?, ?)");
        $stmtT->bind_param("iss", $product_id, $product_name, $product_description);
        $stmtT->execute();

        //Ako admin popuni engleski prevod
        if ($product_name_en && $product_description_en) {
            $stmtT2 = $conn->prepare("INSERT INTO product_translations (product_id, lang, name, description) VALUES (?, 'en', ?, ?)");
            $stmtT2->bind_param("iss", $product_id, $product_name_en, $product_description_en);
            $stmtT2->execute();
        }

        header("location: adminProducts.php");
        exit();
    } else {
        $error = "Greška prilikom dodavanja proizvoda: " . $stmt->error;
    }
}

//Funkcija za upload slika
function uploadImage($input_name) {
    global $upload_dir;

    if (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] == 0) {
        $file_name = basename($_FILES[$input_name]['name']);
        $target_path = $upload_dir . $file_name;

        if (file_exists($target_path)) {
            return $file_name;
        }

        $file_type = mime_content_type($_FILES[$input_name]['tmp_name']);
        if (strpos($file_type, 'image') === false) {
            return null;
        }

        if (move_uploaded_file($_FILES[$input_name]['tmp_name'], $target_path)) {
            return $file_name;
        } else {
            return null;
        }
    }
    return null;
}
?>
