<?php
session_start();
include('server/connection.php');

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
                header('location: login.php?register=You registered successfully');
            } else {
                header('location: register.php?error=Could not register');
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <script src="assets/js/regexEmail.js">
    </script>
    <style>
        #email-error {
            display: block;
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Register</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container text-center">
        <form id="register-forma" method="POST" action="register.php" onsubmit="validateForm(event)">
            <p style="color:red" id="form-error">
                <?php if (isset($_GET['error'])) { echo $_GET['error']; } ?>
            </p>
            <div id="email-error"></div>
            <div class="form-groupa text-center">
                <label>Ime</label><br>
                <input type="text" class="forma-kontrole" id="name-register" name="ime" placeholder="Ime" required />
            </div>
            <div class="form-groupa text-center">
                <label>Email</label><br>
                <input type="text" class="forma-kontrole" id="email-register" name="email" placeholder="Email" required />
            </div>
            <div class="form-groupa text-center">
                <label>Sifra</label><br>
                <input type="password" class="forma-kontrole" id="password-register" name="sifra" placeholder="Sifra" required /><br>
                <input type="checkbox" onclick="myFunction()">Prikazi lozinku
            </div>
            <div class="form-groupa text-center">
                <br><input type="submit" class="btn" id="btn-register" name="btn_register" value="Registruji se" />
            </div>
            <div class="form-groupa text-center">
                <a id="login-strana" href="login.php" class="btn">Vec imate nalog? Uloguji se!</a>
            </div>
        </form>
    </div>
</section>
<script src="assets/js/passwordShowReg.js"></script>
<?php include 'footer.html'; ?>
</body>
</html>
