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
        body{
            background-image:url('../imgs/Bgskije.jpg');
        }

        .container-blog {
            
            margin-top: 5rem;
            padding-top:50px;
            background-image:url('assets/imgs/Bgskije.jpg');
        }

        .section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            padding: 2rem;
            margin-bottom: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .section.show {
            opacity: 1;
            transform: translateY(0);
        }

        .section:nth-child(even) {
            flex-direction: row-reverse;
        }

        .section img {
            width: 45%;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
           
        }

        .section-content {
            width: 50%;
        }

        .section-content h2 {
            color: #004080;
            margin-top: 0;
        }

        .section-content p {
            margin-bottom: 1rem;
        }

    </style>
</head>
<body>
<?php include 'navbar.php';?>

    <div class="container-blog">
        <div class="section" id="section1">
            <img src="assets/imgs/skiblog.jpg" class="h-50" alt="Skiing passion">
            <div class="section-content">
                <h2>O kompaniji</h2>
               <p> Ginic Skije je inovativna kompanija specijalizovana za proizvodnju vrhunskih skija namenjenih profesionalnim skijašima, rekreativcima i freestyle entuzijastima. Osnovana 2024. godine od strane strastvenog skijaša i inženjera Marka Ginića, kompanija je brzo stekla reputaciju zahvaljujući visokom kvalitetu, naprednim tehnologijama i jedinstvenom dizajnu svojih proizvoda.</p>
            </div>
        </div>

        <div class="section" id="section2">
            <img src="assets/imgs/skiblog2.jpg" alt="Sustainability and service">
            <div class="section-content">
                <h2>Vizija i misije</h2>
                <p>Ginic Skije teži tome da postane lider u industriji skijaške opreme, pružajući sportistima najbolje moguće performanse na snegu. Njihova misija je da spoje tradiciju i inovaciju, stvarajući skije koje omogućavaju savršenu kontrolu, stabilnost i brzinu, bez obzira na uslove na stazi.</p>
            </div>
        </div>

        <div class="section" id="section3">
            <img src="assets/imgs/skiblog3.jpeg" alt="Fun facts about Alpine Edge">
            <div class="section-content">
                <h2>Tehnologija i inovacije</h2>
                <p>Kompanija koristi najsavremenije materijale, uključujući karbonska vlakna, titanijumske legure i specijalne drvene jezgre kako bi obezbedila optimalan balans između čvrstoće i fleksibilnosti. Posebna pažnja posvećena je aerodinamičkom dizajnu i specijalnom premazu koji smanjuje trenje i poboljšava klizanje na snegu.</p>
        </div>
    </div>
    <script src="assets/js/scrollBlog.js">
    </script>
     <?php include 'footer.html';?>
</body>
</html>
