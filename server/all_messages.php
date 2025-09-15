<?php
    $stmt = $conn->prepare("SELECT * FROM message");

    $stmt ->execute();
                                
    $poruke= $stmt -> get_result();

?>