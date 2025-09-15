<?php
session_start();
include('../server/connection.php');

if(isset($_POST['send_message'])){
    $name=$_POST['ime'];
    $email=$_POST['email'];
    $subject=$_POST['naslov'];
    $message=$_POST['poruka'];
    $user_id=$_SESSION['user_id'];

    $stmt=$conn->prepare("INSERT INTO message(user_id,user_name,user_email,subject,message) VALUES (?,?,?,?,?);");

    $stmt->bind_param('issss',$user_id,$name,$email,$subject,$message);

    $stmt->execute();
header('Location: ../account.php');
}


?>