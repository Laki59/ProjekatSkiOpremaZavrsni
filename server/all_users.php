<?php
    $stmt = $conn->prepare("SELECT * FROM users");

    $stmt ->execute();
                                
    $ljudi= $stmt -> get_result();

?>