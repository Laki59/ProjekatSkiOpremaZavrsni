<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <style>

body {
        margin: 0;
        padding: 0;
        background-image: url('assets/imgs/alpi.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
    }
    </style>
</head>
<body>
<?php include 'navbar.php';?>

    <div class="kontakt-container">
        <section class="kontakt-info">
            <div class="info-box">
                <i class="fas fa-phone"></i>
                <h3><?=$Language["telephone"]?></h3>
                <p>062489508</p>
            </div>
            <div class="info-box">
                <i class="fas fa-envelope"></i>
                <h3>Email</h3>
                <p>lazar3021@its.edu.rs</p>
            </div>
            <div class="info-box">
                <i class="fas fa-map-marker-alt"></i>
                <h3><?=$Language["address"]?></h3>
                <p>Belgrade<br>Kadinjacka 42</p>
            </div>
        </section>

        <section class="kontakt-form">
            <h2><?=$Language["msg"]?>!</h2>
            <form method="post" action="php/submitMessage.php">
                <div class="kontakt-grupa">
                    <label for="name"><?=$Language["name"]?></label>
                    <input type="text" id="ime" name="ime" value="<?php echo $_SESSION["user_name"];?>" readonly placeholder="Ime" required>
                </div>
                <div class="kontakt-grupa">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $_SESSION["user_email"];?>" readonly required>
                </div>
                <div class="kontakt-grupa">
                    <label for="subject"><?=$Language["msghead"]?></label>
                    <input type="text" id="naslov" name="naslov" placeholder="<?=$Language["msghead"]?>" required>
                </div>
                <div class="kontakt-grupa">
                    <label for="poruka"><?=$Language["message"]?></label>
                    <textarea id="poruka" name="poruka" placeholder="<?=$Language["message"]?>" required></textarea>
                </div>
                <div class="kontakt-grupa">
                    <button type="submit" name="send_message" id="send_message">Submit</button>
                </div>
            </form>
        </section>

        <section class="map">
            <h2>Find Us</h2>
            <div style="width: 100%"><iframe width="100%" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=comtrade%20novi%20beograd+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="https://www.gps.ie/">gps devices</a></iframe></div>
        </section>
    </div>

    <?php include 'footer.html';?>

</body>
</html>

