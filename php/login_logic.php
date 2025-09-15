<?php
session_start();
include(__DIR__ . '/../server/connection.php');

$error = isset($_GET['error']) ? $_GET['error'] : '';

if (isset($_SESSION['logged_in'])) {
header('Location: /PROJEKAT/account.php');
    exit;
}
if (isset($_POST['btn_login'])) {
    $email = $_POST['email'];
    $password = $_POST['sifra'];

    // prvo pronalazi usera po emailu
    $stmt = $conn->prepare("SELECT user_id, user_name, user_email, user_password 
                            FROM users 
                            WHERE user_email=? LIMIT 1");
    $stmt->bind_param('s', $email);

    if ($stmt->execute()) {
        $stmt->bind_result($user_id, $user_name, $user_email, $hashed_password);
        $stmt->store_result();

        if ($stmt->num_rows() == 1) {
            $stmt->fetch();

            // sada proverava hash
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id']    = $user_id;
                $_SESSION['user_name']  = $user_name;
                $_SESSION['user_email'] = $user_email;
                $_SESSION['logged_in']  = true;

                header('Location: ../account.php?message=Uspesno logovanje');
                exit;
            } else {
                header('Location: ../login.php?error=Netacan email ili sifra.');
                exit;
            }
        } else {
            header('Location: ../login.php?error=Netacan email ili sifra.');
            exit;
        }
    } else {
        header('Location: ../login.php?error=Something went wrong');
        exit;
    }
}
?>
