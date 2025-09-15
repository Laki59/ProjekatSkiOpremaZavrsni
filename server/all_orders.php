<?php

$stmt = $conn->prepare("SELECT * FROM orders");

$stmt ->execute();
                            
$stvari= $stmt -> get_result();
?>