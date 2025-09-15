<?php
include('server/connection.php');

/*Proveravamo da li je dugme kliknuto i da li je proslednjen order id,ako jeste,prikazi sve stvari u tom orderu */
if(isset($_POST['detalji-btn'])&& isset($_POST['order_id'])){

    $order_id=$_POST['order_id'];

    $stmt=$conn->prepare("SELECT * FROM order_items WHERE order_id=?");

    $stmt->bind_param('i',$order_id);

    $stmt->execute();

    $proizvod_detalji=$stmt->get_result();

}else{
    header("location: account.php");
    exit;
}

?>