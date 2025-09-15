<?php

include('connection.php');
//sve producte pise u shop.php
$stmt = $conn->prepare("SELECT * FROM products");

$stmt ->execute();

$all_products = $stmt -> get_result();

?>