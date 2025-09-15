<?php
session_start();
include('server/connection.php');

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

// Logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('location: login.php');
    exit;
}

// Get user orders
$proizvodi = [];
if (isset($_SESSION['logged_in'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY order_date DESC");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $proizvodi = $stmt->get_result();
}

// Update za nalog
if (isset($_POST['update_account'])) {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['user_name'];
    $email = $_POST['user_email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['password-confirm'];

    // ako hoce da promeni nalog
    if (!empty($password)) {
        if ($password !== $confirm_password) {
            header("location: account.php?error=Lozinke se ne poklapaju");
            exit;
        }
        if (strlen($password) < 5) {
            header("location: account.php?error=Lozinka mora imati bar 5 karaktera");
            exit;
        }

        $stmt = $conn->prepare("UPDATE users SET user_name=?, user_email=?, user_password=? WHERE user_id=?");
        $stmt->bind_param("sssi", $name, $email, $password, $user_id);
    } else {
        // ako ne menja password
        $stmt = $conn->prepare("UPDATE users SET user_name=?, user_email=? WHERE user_id=?");
        $stmt->bind_param("ssi", $name, $email, $user_id);
    }

    if ($stmt->execute()) {
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        header("location: account.php?message=Nalog uspešno izmenjen");
        exit;
    } else {
        header("location: account.php?error=Došlo je do greške pri izmeni naloga");
        exit;
    }
}
?>
