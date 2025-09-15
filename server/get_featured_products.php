<?php
include('connection.php');
// ovo je select za featured na index.php i ima limit od 4
$stmt = $conn->prepare("SELECT * FROM products order by product_id desc LIMIT 4");
$stmt ->execute();
$featured_products = $stmt -> get_result();
?>