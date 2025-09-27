<?php
session_start();
include(__DIR__ . '/../server/connection.php');

/* Uzima informacije sa forme na klik */
if (isset($_POST['btn_register'])) {
    $name = $_POST['ime'];
    $email = $_POST['email'];
    $password = $_POST['sifra'];

    /* Password moora biti veci on 5 znakova */
    if (strlen($password) < 5) {
        header('location: register.php?error=Password must be longer than 5 characters');
    } else {
        /* Gledamo da li email vec postoji */
        $emailstmt = $conn->prepare("SELECT count(*) FROM users WHERE user_email=?");
        $emailstmt->bind_param('s', $email);
        $emailstmt->execute();
        $emailstmt->bind_result($num_rows);
        $emailstmt->store_result();
        $emailstmt->fetch();

        if ($num_rows != 0) {
            header('location: register.php?error=User with this email already exists');
        } else {
            /* Insertujemo novog usera u DB */
/* Hashiranje lozinke */
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)");
$stmt->bind_param('sss', $name, $email, $hashed_password);
            if ($stmt->execute()) {
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;
                $_SESSION['loggedin'] = true;
                header('Location: login.php?register=You registered successfully');
            } else {
                header('location: register.php?error=Could not register');
            }
        }
    }
}
?>